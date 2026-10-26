<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
public function index(Request $request)
{
    $user = $request->user();

    $companies = Company::query()
        ->orderBy('name')
        ->get();

    $query = \App\Models\ShortUrl::query();

    if ($user->role === 'SuperAdmin') {
        // SuperAdmin can see URLs from all companies.
    } elseif ($user->role === 'Admin') {
        $query->where('company_id', $user->company_id);
    } elseif ($user->role === 'Member') {
        $query->where('user_id', $user->id);
    } else {
        abort(403, 'You are not allowed to view short URLs.');
    }

    $shortUrls = $query->latest()->get();

    return view('dashboard', [
        'user' => $user,
        'companies' => $companies,
        'shortUrls' => $shortUrls,
    ]);
}

}
