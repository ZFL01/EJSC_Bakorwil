<?php

use App\Models\Kegiatan;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Tandai Kegiatan Lewat sebagai "Selesai"
|--------------------------------------------------------------------------
|
| Kegiatan yang tanggalnya sudah lewat namun masih berstatus
| "akan_datang" atau "berlangsung" otomatis diubah menjadi "selesai".
| Dapat dijalankan manual: php artisan kegiatan:tandai-selesai
|
*/

Artisan::command('kegiatan:tandai-selesai', function () {
    $lewat = Kegiatan::whereDate('tanggal_kegiatan', '<', now()->toDateString())
        ->whereIn('status', ['akan_datang', 'berlangsung']);

    $total = $lewat->count();

    if ($total === 0) {
        $this->info('Tidak ada kegiatan lewat yang perlu ditandai selesai.');

        return;
    }

    $lewat->update(['status' => 'selesai']);

    $this->info("{$total} kegiatan lewat telah ditandai sebagai selesai.");
})->purpose('Tandai kegiatan yang tanggalnya sudah lewat sebagai selesai');

// Jalankan otomatis setiap hari pukul 00:05
Schedule::command('kegiatan:tandai-selesai')
    ->dailyAt('00:05')
    ->name('kegiatan-tandai-selesai')
    ->withoutOverlapping()
    ->onOneServer();
