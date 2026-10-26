<?php

namespace App\Http\Controllers;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        $query = ShortUrl::query();

        // SuperAdmin can see all companies' URLs.
        if ($user->role === 'SuperAdmin') {
            // No company filter is required.
        }

        // Admin can see URLs created within their company.
        elseif ($user->role === 'Admin') {
            $query->where('company_id', $user->company_id);
        }

        // Member can see only URLs created by themselves.
        elseif ($user->role === 'Member') {
            $query->where('user_id', $user->id);
        }

        // Reject any unsupported role.
        else {
            abort(403, 'You are not allowed to view short URLs.');
        }

        $shortUrls = $query->latest()->get();

        return response()->json([
            'short_urls' => $shortUrls,
        ]);
    }

    
    public function store(Request $request)
    {
        $user = $request->user();

        // Only Admin and Member can create short URLs.
        if (! in_array($user->role, ['Admin', 'Member'], true)) {
            abort(403, 'You are not allowed to create short URLs.');
        }

        if (! $user->company_id) {
            abort(403, 'Your account is not linked to a company.');
        }

        $validated = $request->validate([
            'original_url' => ['required', 'url', 'max:2048'],
        ]);

        do {
            $shortCode = Str::random(6);

            $query = ShortUrl::query();
            $query->where('short_code', $shortCode);
        } while ($query->exists());

        $shortUrl = ShortUrl::create([
            'original_url' => $validated['original_url'],
            'short_code' => $shortCode,
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ]);

        // Browser form submission should return to the dashboard.
        if (! $request->expectsJson()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Short URL created: ' . url($shortUrl->short_code));
        }

        // API requests should receive JSON.
        return response()->json([
            'message' => 'Short URL created successfully.',
            'original_url' => $shortUrl->original_url,
            'short_url' => url($shortUrl->short_code),
        ], 201);
    }

    public function redirectToOriginal(string $code){

        // $Shorturl = ShortUrl::where('short_code',$code)->firstOrFail();
        $query = ShortUrl::query();
        $query->where('short_code', $code);
        $shortUrl = $query->firstOrFail();


        if ($shortUrl->expires_at && $shortUrl->expires_at->isPast()) {
            abort(410, 'This short URL has expired.');
        }
        $shortUrl->increment('clicks');

        return redirect()->away($shortUrl->original_url);
    }
}
