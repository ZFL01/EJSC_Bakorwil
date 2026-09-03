<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\GithubAuthController;
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
    | GitHub OAuth
    */
    Route::get('/auth/github/redirect', [GithubAuthController::class, 'redirect'])->name('github.redirect');
    Route::get('/auth/github/callback', [GithubAuthController::class, 'callback'])->name('github.callback');
    Route::get('/auth/github/role', [GithubAuthController::class, 'showRoleSelection'])->name('github.role');
    Route::post('/auth/github/complete', [GithubAuthController::class, 'completeRegistration'])->name('github.complete');
    Route::post('/auth/github/cancel', [GithubAuthController::class, 'cancelRegistration'])->name('github.cancel');
    Route::get('/auth/github/waiting', [GithubAuthController::class, 'showWaiting'])->name('github.waiting');
});

Route::middleware('auth')->group(function () {
    // Handle logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});