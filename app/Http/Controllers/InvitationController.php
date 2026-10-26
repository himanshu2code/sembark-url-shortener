<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    
public function store(Request $request)
{
    $currentUser = Auth::user();

    // Only SuperAdmin and Admin can send invitations.
    if (! in_array($currentUser->role, ['SuperAdmin', 'Admin'], true)) {
        abort(403, 'You are not allowed to send invitations.');
    }

    // SuperAdmin can invite only Admins.
    // Admin can invite Admins or Members.
    $allowedRoles = ['Admin', 'Member'];

    if ($currentUser->role === 'SuperAdmin') {
        $allowedRoles = ['Admin'];
    }

    $validated = $request->validate([
        'email' => ['required', 'email', 'max:255'],
        'role' => ['required', 'in:' . implode(',', $allowedRoles)],
    ]);

    // SuperAdmin selects the company.
    if ($currentUser->role === 'SuperAdmin') {
        $companyData = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
        ]);

        $companyId = $companyData['company_id'];
    } else {
        // Admin can invite users only to their own company.
        $companyId = $currentUser->company_id;

        if (! $companyId) {
            abort(403, 'Your account is not linked to a company.');
        }
    }

    // Check whether the email already belongs to a user.
    $existingUserQuery = User::query();
    $existingUserQuery->where('email', $validated['email']);

    if ($existingUserQuery->exists()) {
        $message = 'This email is already registered. Please use a different email address.';

        if (! $request->expectsJson()) {
            return redirect()->back()
                ->withInput($request->only('email', 'role', 'company_id'))
                ->withErrors(['email' => $message]);
        }

        return response()->json([
            'message' => $message,
        ], 422);
    }

    // Prevent duplicate active invitations for this company.
    $existingInvitationQuery = Invitation::query();
    $existingInvitationQuery->where('email', $validated['email']);
    $existingInvitationQuery->where('company_id', $companyId);
    $existingInvitationQuery->whereNull('accepted_at');
    $existingInvitationQuery->where('expires_at', '>', now());

    if ($existingInvitationQuery->exists()) {
        $message = 'A pending invitation already exists for this email and company.';

        if (! $request->expectsJson()) {
            return redirect()->back()
                ->withInput($request->only('email', 'role', 'company_id'))
                ->withErrors(['email' => $message]);
        }

        return response()->json([
            'message' => $message,
        ], 422);
    }

    // Create the invitation with a seven-day expiry.
    $invitation = Invitation::create([
        'email' => $validated['email'],
        'role' => $validated['role'],
        'company_id' => $companyId,
        'invited_by' => $currentUser->id,
        'token' => Str::random(64),
        'expires_at' => now()->addDays(7),
    ]);

    // Generate the invitation URL.
    $invitationUrl = route('invitations.accept', [
        'token' => $invitation->token,
    ]);

    // Browser form submission: show the designed invitation page.
    if (! $request->expectsJson()) {
        return view('invitations.created', [
            'invitation' => $invitation,
            'invitationUrl' => $invitationUrl,
        ]);
    }

    // API request: return JSON.
    return response()->json([
        'message' => 'Invitation created successfully.',
        'invitation_url' => $invitationUrl,
        'invitation' => $invitation,
    ], 201);
}


    public function accept(string $token)
    {
        $query = Invitation::query();
        $query->where('token', $token);
        $query->whereNull('accepted_at');
        $query->where('expires_at', '>', now());

        $invitation = $query->firstOrFail();

        return view('invitations.accept', [
            'invitation' => $invitation,
            'token' => $token,
        ]);
    }

    public function register(Request $request, string $token)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create the invited user and accept the invitation atomically.
        $user = DB::transaction(function () use ($validated, $token) {
            $query = Invitation::query();
            $query->where('token', $token);
            $query->whereNull('accepted_at');
            $query->where('expires_at', '>', now());

            $invitation = $query->lockForUpdate()->firstOrFail();

            $existingUserQuery = User::query();
            $existingUserQuery->where('email', $invitation->email);

            if ($existingUserQuery->exists()) {
                abort(
                    409,
                    'An account already exists for this invitation email.'
                );
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $invitation->email,
                'password' => Hash::make($validated['password']),
                'role' => $invitation->role,
                'company_id' => $invitation->company_id,
            ]);

            $invitation->accepted_at = now();
            $invitation->save();

            return $user;
        });

        // Log in the newly registered user.
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
