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
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/mentor', [PublicController::class, 'mentor'])->name('mentor');

Route::get('/talenta', [PublicController::class, 'talenta'])->name('talenta');

Route::get('/client', [PublicController::class, 'client'])->name('client');

/*
|--------------------------------------------------------------------------
| GIS API (dipakai oleh peta interaktif di home)
|--------------------------------------------------------------------------
*/

Route::get('/api/gis/tahun', [GisMapController::class, 'years']);
Route::get('/api/gis/wilayah', [GisMapController::class, 'wilayah']);

Route::get('/fasilitas', function () {
    return view('fasilitas');
})->name('fasilitas');

Route::get('/tentang-kami', [PublicController::class, 'tentangKami'])->name('tentang-kami');

Route::get('/kegiatan', function () {
    return view('kegiatan');
})->name('kegiatan');

/*
|--------------------------------------------------------------------------
| Kelola (Admin Only)
|--------------------------------------------------------------------------
|
| Fitur kelola data Mentor, Talenta, dan Client hanya dapat diakses
| oleh Admin melalui panel admin (/admin/...), karena hanya admin
| yang memiliki hak CRUD penuh. URL lama dialihkan agar tetap kompatibel;
| middleware auth+admin akan mengarahkan non-admin ke halaman login.
|
*/

Route::redirect('/kelola/mentor', '/admin/mentors')->name('kelola.mentor');
Route::redirect('/kelola/talenta', '/admin/talents')->name('kelola.talenta');
Route::redirect('/kelola/client', '/admin/clients')->name('kelola.client');
