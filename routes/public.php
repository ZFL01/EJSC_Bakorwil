<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
| Public Routes
|
| Routes accessible to public visitors.
| Public users can view non-sensitive data.
| Authenticated users can register for kegiatans.
|
| CATATAN: rute home (/), clients, mentors, talents yang sebelumnya
| duplikat di sini sudah dihapus - versi aktif ada di routes/web.php
| (public.index, mentor, talenta, client + masing-masing detail).
|
*/

Route::name('public.')->group(function () {
    // Kegiatans (public view)
    Route::prefix('kegiatans')->name('kegiatans.')->group(function () {
        Route::get('/', [PublicController::class, 'kegiatans'])->name('index');
        Route::get('/{kegiatan}', [PublicController::class, 'kegiatanShow'])->name('show');

        // Registration (requires authentication)
        Route::middleware('auth')->group(function () {
            Route::post('/{kegiatan}/register', [PublicController::class, 'kegiatanRegister'])->name('register');
            Route::delete('/{kegiatan}/cancel', [PublicController::class, 'kegiatanCancel'])->name('cancel');
        });
    });
});
