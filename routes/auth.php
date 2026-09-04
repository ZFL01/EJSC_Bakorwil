<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LinkedinAuthController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Show login form
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    
    // Handle login
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    /*
    | Google OAuth
    */
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
    Route::get('/auth/google/role', [GoogleAuthController::class, 'showRoleSelection'])->name('google.role');
    Route::post('/auth/google/complete', [GoogleAuthController::class, 'completeRegistration'])->name('google.complete');
    Route::post('/auth/google/cancel', [GoogleAuthController::class, 'cancelRegistration'])->name('google.cancel');
    Route::get('/auth/google/waiting', [GoogleAuthController::class, 'showWaiting'])->name('google.waiting');

    /*
    | LinkedIn OAuth
    */
    Route::get('/auth/linkedin/redirect', [LinkedinAuthController::class, 'redirect'])->name('linkedin.redirect');
    Route::get('/auth/linkedin/callback', [LinkedinAuthController::class, 'callback'])->name('linkedin.callback');
    Route::get('/auth/linkedin/role', [LinkedinAuthController::class, 'showRoleSelection'])->name('linkedin.role');
    Route::post('/auth/linkedin/complete', [LinkedinAuthController::class, 'completeRegistration'])->name('linkedin.complete');
    Route::post('/auth/linkedin/cancel', [LinkedinAuthController::class, 'cancelRegistration'])->name('linkedin.cancel');
    Route::get('/auth/linkedin/waiting', [LinkedinAuthController::class, 'showWaiting'])->name('linkedin.waiting');
});

Route::middleware('auth')->group(function () {
    // Handle logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});