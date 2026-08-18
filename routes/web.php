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

Route::get('/fasilitas', function () {
    return view('fasilitas');
})->name('fasilitas');

Route::get('/tentang-kami', function () {
    // TODO: ganti dengan query database asli (Mentor::count(), Talenta::count(), Client::count(), dst)
    $statistik = [
        'mentor'   => 150,
        'talenta'  => 500,
        'client'   => 80,
        'kepuasan' => 98,
    ];

    // Contoh data pertumbuhan platform per bulan, untuk line chart
    $pertumbuhan = [
        'labels'  => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
        'mentor'  => [40, 55, 70, 85, 100, 118, 135, 150],
        'talenta' => [120, 180, 230, 290, 350, 410, 460, 500],
        'client'  => [10, 18, 28, 38, 48, 58, 70, 80],
    ];

    // Contoh distribusi talenta berdasarkan kategori keahlian, untuk pie/doughnut chart
    $distribusiTalenta = [
        'labels' => ['Teknologi', 'Desain', 'Bisnis', 'Marketing', 'Lainnya'],
        'data'   => [180, 120, 90, 70, 40],
    ];

    // Contoh distribusi mentor berdasarkan bidang, untuk bar chart
    $distribusiMentor = [
        'labels' => ['Teknologi', 'Bisnis', 'Desain', 'Pendidikan', 'Lainnya'],
        'data'   => [55, 35, 25, 20, 15],
    ];

    return view('tentang-kami', compact(
        'statistik',
        'pertumbuhan',
        'distribusiTalenta',
        'distribusiMentor'
    ));
})->name('tentang-kami');

Route::get('/kegiatan', function () {
    return view('kegiatan');
})->name('kegiatan');

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
