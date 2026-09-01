<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\GisMapController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

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
| PUBLIC HOME
|--------------------------------------------------------------------------
|
| Home menggunakan home.blade.php
| Route name: public.index
|
*/

Route::get('/', [PublicController::class, 'index'])
    ->name('public.index');


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
| Kelola
|--------------------------------------------------------------------------
*/

Route::redirect('/kelola/mentor', '/admin/mentors')
    ->name('kelola.mentor');

Route::redirect('/kelola/talenta', '/admin/talents')
    ->name('kelola.talenta');

Route::redirect('/kelola/client', '/admin/clients')
    ->name('kelola.client');