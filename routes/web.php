<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/registrasi', function () {
    return view('auth.registrasi');
})->name('registrasi');

/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/mentor', function () {
    return view('mentor');
})->name('mentor');

Route::get('/talenta', function () {
    return view('talenta');
})->name('talenta');

Route::get('/client', function () {
    return view('client');
})->name('client');

Route::get('/gis', function () {
    return view('gis');
})->name('gis');

/*
|--------------------------------------------------------------------------
| Kelola
|--------------------------------------------------------------------------
*/

Route::get('/kelola/mentor', function () {
    return view('kelola.mentor');
})->name('kelola.mentor');

Route::get('/kelola/talenta', function () {
    return view('kelola.talenta');
})->name('kelola.talenta');

Route::get('/kelola/client', function () {
    return view('kelola.client');
})->name('kelola.client');