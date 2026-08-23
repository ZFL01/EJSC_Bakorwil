<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Routes accessible to public visitors.
| Public users can view non-sensitive data.
| Authenticated users can register for kegiatans.
|
*/

Route::name('public.')->group(function () {
    // Home page
    Route::get('/', [PublicController::class, 'index'])->name('index');
    
    // Clients (public view)
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [PublicController::class, 'clients'])->name('index');
        Route::get('/{client}', [PublicController::class, 'clientShow'])->name('show');
    });
    
    // Mentors (public view)
    Route::prefix('mentors')->name('mentors.')->group(function () {
        Route::get('/', [PublicController::class, 'mentors'])->name('index');
        Route::get('/{mentor}', [PublicController::class, 'mentorShow'])->name('show');
    });
    
    // Talents (public view)
    Route::prefix('talents')->name('talents.')->group(function () {
        Route::get('/', [PublicController::class, 'talents'])->name('index');
        Route::get('/{talent}', [PublicController::class, 'talentShow'])->name('show');
    });
    
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
