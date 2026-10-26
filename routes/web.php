<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
});

Route::post('/short-urls', [ShortUrlController::class, 'store'])->middleware('auth');

Route::get('/{code}', [ShortUrlController::class, 'redirectToOriginal'])->where('code', '[A-Za-z0-9]{6}');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/invitations', [InvitationController::class, 'store'])->middleware('auth');
Route::get('/invitations/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invitations/{token}/register', [
    InvitationController::class,
    'register',
])->name('invitations.register');