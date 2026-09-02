<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Routes for user authentication (login/logout).
|
*/

Route::middleware('guest')->group(function () {
    // Show login form
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    
    // Handle login
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    /*
    | Google OAuth (Laravel Socialite)
    | Bisa dijalankan di localhost — tidak butuh hosting.
    */
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
    Route::get('/auth/google/role', [GoogleAuthController::class, 'showRoleSelection'])->name('google.role');
    Route::post('/auth/google/complete', [GoogleAuthController::class, 'completeRegistration'])->name('google.complete');
    Route::post('/auth/google/cancel', [GoogleAuthController::class, 'cancelRegistration'])->name('google.cancel');

    // Halaman "menunggu persetujuan admin" setelah daftar via Google
    Route::get('/auth/google/waiting', [GoogleAuthController::class, 'showWaiting'])->name('google.waiting');
});

Route::middleware('auth')->group(function () {
    // Handle logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
