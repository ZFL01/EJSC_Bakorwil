<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\TalentController;
use App\Http\Controllers\Admin\KegiatanController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All routes here are protected by:
| - auth middleware: ensures user is logged in
| - admin middleware: ensures user has admin role
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    
    // Activity Logs
    Route::get('/activity-logs', [DashboardController::class, 'activityLogs'])->name('activity-logs');
    
    // Clients Management
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('show');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::put('/{client}', [ClientController::class, 'update'])->name('update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
    });
    
    // Mentors Management
    Route::prefix('mentors')->name('mentors.')->group(function () {
        Route::get('/', [MentorController::class, 'index'])->name('index');
        Route::get('/create', [MentorController::class, 'create'])->name('create');
        Route::post('/', [MentorController::class, 'store'])->name('store');
        Route::get('/{mentor}', [MentorController::class, 'show'])->name('show');
        Route::get('/{mentor}/edit', [MentorController::class, 'edit'])->name('edit');
        Route::put('/{mentor}', [MentorController::class, 'update'])->name('update');
        Route::delete('/{mentor}', [MentorController::class, 'destroy'])->name('destroy');
    });
    
    // Talents Management
    Route::prefix('talents')->name('talents.')->group(function () {
        Route::get('/', [TalentController::class, 'index'])->name('index');
        Route::get('/create', [TalentController::class, 'create'])->name('create');
        Route::post('/', [TalentController::class, 'store'])->name('store');
        Route::get('/{talent}', [TalentController::class, 'show'])->name('show');
        Route::get('/{talent}/edit', [TalentController::class, 'edit'])->name('edit');
        Route::put('/{talent}', [TalentController::class, 'update'])->name('update');
        Route::delete('/{talent}', [TalentController::class, 'destroy'])->name('destroy');
    });
    
    // Kegiatans Management
    Route::prefix('kegiatans')->name('kegiatans.')->group(function () {
        Route::get('/', [KegiatanController::class, 'index'])->name('index');
        Route::get('/create', [KegiatanController::class, 'create'])->name('create');
        Route::post('/', [KegiatanController::class, 'store'])->name('store');
        Route::get('/{kegiatan}', [KegiatanController::class, 'show'])->name('show');
        Route::get('/{kegiatan}/edit', [KegiatanController::class, 'edit'])->name('edit');
        Route::put('/{kegiatan}', [KegiatanController::class, 'update'])->name('update');
        Route::delete('/{kegiatan}', [KegiatanController::class, 'destroy'])->name('destroy');
        
        // Participants management
        Route::get('/{kegiatan}/participants', [KegiatanController::class, 'participants'])->name('participants');
        Route::put('/{kegiatan}/participants/{participant}', [KegiatanController::class, 'updateParticipantStatus'])->name('participants.update-status');
    });
});
