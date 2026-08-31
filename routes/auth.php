<?php

use Illuminate\Support\Facades\Route;
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
});

Route::middleware('auth')->group(function () {
    // Handle logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
