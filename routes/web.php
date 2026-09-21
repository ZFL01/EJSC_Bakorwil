<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GisMapController;
use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\Admin\RoomBookingController as AdminRoomBookingController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;

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
|
| Alias dari halaman /kegiatans (public.kegiatans.index).
| Keduanya DB-driven via PublicController@kegiatans.
|
*/

Route::get('/kegiatan', [PublicController::class, 'kegiatans'])
    ->name('kegiatan');

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

/*
|--------------------------------------------------------------------------
| Booking Ruangan
|--------------------------------------------------------------------------
*/

Route::get(
    '/booking-ruangan',
    [RoomBookingController::class, 'index']
)->name('booking.index');

Route::get(
    '/booking-ruangan/jadwal',
    [RoomBookingController::class, 'schedule']
)->name('booking.schedule');

Route::post(
    '/booking-ruangan',
    [RoomBookingController::class, 'store']
)->name('booking.store');

Route::get(
    '/booking-ruangan/success/{id}',
    [RoomBookingController::class, 'success']
)->name('booking.success');

/*
|--------------------------------------------------------------------------
| Detail Booking dari Jadwal
|--------------------------------------------------------------------------
*/

Route::get(
    '/booking-ruangan/detail/{id}',
    [RoomBookingController::class, 'detail']
)->name('booking.detail');

/*
|--------------------------------------------------------------------------
| Booking Saya
|--------------------------------------------------------------------------
*/

Route::get(
    '/booking-saya',
    [RoomBookingController::class, 'myBookings']
)->middleware('auth')
 ->name('booking.my');
 /*
|--------------------------------------------------------------------------
| Admin Booking Ruangan
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth'])
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/bookings',
            [AdminRoomBookingController::class, 'index']
        )->name('bookings.index');

        Route::get(
            '/bookings/rooms/create',
            [AdminRoomBookingController::class, 'createRoom']
        )->name('bookings.rooms.create');

        Route::post(
            '/bookings/rooms',
            [AdminRoomBookingController::class, 'storeRoom']
        )->name('bookings.rooms.store');

        Route::delete(
            '/bookings/rooms/{room}',
            [AdminRoomBookingController::class, 'destroyRoom']
        )->name('bookings.rooms.destroy');

        Route::get(
            '/bookings/{id}',
            [AdminRoomBookingController::class, 'show']
        )->name('bookings.show');

        Route::post(
            '/bookings/{id}/approve',
            [AdminRoomBookingController::class, 'approve']
        )->name('bookings.approve');

        Route::post(
            '/bookings/{id}/reject',
            [AdminRoomBookingController::class, 'reject']
        )->name('bookings.reject');

        Route::post(
            '/bookings/{id}/cancel',
            [AdminRoomBookingController::class, 'cancel']
        )->name('bookings.cancel');

        Route::post(
            '/bookings/{id}/complete',
            [AdminRoomBookingController::class, 'complete']
        )->name('bookings.complete');
    });
    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */
    Route::post('/rating', [\App\Http\Controllers\RatingController::class, 'store'])
    ->middleware('auth')
    ->name('rating.store');

    Route::get(
    '/admin/ratings',
    [AdminRatingController::class, 'index']
    )
        ->middleware('auth')
        ->name('admin.ratings.index');

    Route::delete(
        '/admin/ratings/{rating}',
        [AdminRatingController::class, 'destroy']
    )
        ->middleware('auth')
        ->name('admin.ratings.destroy');

    Route::post(
    '/admin/ratings',
    [\App\Http\Controllers\Admin\RatingController::class, 'store']
)
    ->middleware('auth')
    ->name('admin.ratings.store');