<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GisMapController;
use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/registrasi', [RegisterController::class, 'showRegistrationForm'])
    ->name('registrasi');

Route::post('/registrasi', [RegisterController::class, 'register']);

Route::get('/registrasi/selesai', [RegisterController::class, 'showWaiting'])
    ->name('registrasi.waiting');

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

Route::get('/reset-password/{token}', function (Request $request, string $token) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password_hash' => Hash::make($password),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);

})->name('password.store');

/*
|--------------------------------------------------------------------------
| PUBLIC HOME
|--------------------------------------------------------------------------
|
| Home menggunakan home.blade.php
| Route name: public.index
|
*/

Route::get('/gis', [GisMapController::class, 'index'])
    ->name('gis');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/mentor', [PublicController::class, 'mentors'])
    ->name('mentor');

Route::get('/talenta', [PublicController::class, 'talents'])
    ->name('talenta');

Route::get('/client', [PublicController::class, 'clients'])
    ->name('client');

/*
|--------------------------------------------------------------------------
| Detail Mentor / Talenta / Client
|--------------------------------------------------------------------------
*/

Route::get('/mentor/{mentor}', [PublicController::class, 'mentorShow'])
    ->name('mentor.show')
    ->where('mentor', '[0-9]+');

Route::get('/talenta/{talent}', [PublicController::class, 'talentShow'])
    ->name('talenta.show')
    ->where('talent', '[0-9]+');

Route::get('/client/{client}', [PublicController::class, 'clientShow'])
    ->name('client.show')
    ->where('client', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Tentang Kami
|--------------------------------------------------------------------------
*/

Route::get('/tentang-kami', [PublicController::class, 'tentangKami'])
    ->name('tentang-kami');

/*
|--------------------------------------------------------------------------
| Fasilitas
|--------------------------------------------------------------------------
*/

Route::get('/fasilitas', function () {
    return view('fasilitas');
})->name('fasilitas');

/*
|--------------------------------------------------------------------------
| Kegiatan
|--------------------------------------------------------------------------
*/

Route::get('/kegiatan', function () {
    return view('kegiatan');
})->name('kegiatan');

/*
|--------------------------------------------------------------------------
| GIS API
|--------------------------------------------------------------------------
*/

Route::get('/api/gis/tahun', [GisMapController::class, 'years']);

Route::get('/api/gis/wilayah', [GisMapController::class, 'wilayah']);

/*
|--------------------------------------------------------------------------
| GIS Page
|--------------------------------------------------------------------------
*/

Route::get('/gis', function () {
    return redirect('/');
})->name('gis');

/*
|--------------------------------------------------------------------------
| Kelola
|--------------------------------------------------------------------------
*/

Route::redirect('/kelola/mentor', '/admin/mentors')
    ->name('kelola.mentor');

Route::redirect('/kelola/talenta', '/admin/talents')
    ->name('kelola.talenta');

Route::redirect('/kelola/client', '/admin/clients')
    ->name('kelola.client');
