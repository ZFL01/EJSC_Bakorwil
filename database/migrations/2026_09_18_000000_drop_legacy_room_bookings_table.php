<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Membersihkan tabel legacy `room_bookings` (skema lama dari branch lain:
 * kolom booking_date/start_time/end_time/participant_count, status 'pending')
 * yang tidak dipakai lagi oleh aplikasi.
 *
 * Sekaligus memastikan tabel `bookings` benar-benar ada. Pada sebagian
 * environment, record migration create_bookings_table sudah tercatat "Ran"
 * (misal DB hasil restore/dump) padahal tabelnya belum pernah dibuat,
 * sehingga `php artisan migrate` tidak membuatnya. Migration ini mengatasinya.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Pastikan tabel `bookings` ada (tanpa duplikasi definisi skema).
        if (! Schema::hasTable('bookings')) {
            (require database_path(
                'migrations/2026_09_17_111641_create_bookings_table.php'
            ))->up();
        }

        // 2. Bersihkan tabel legacy yang tidak terpakai.
        Schema::dropIfExists('room_bookings');
    }

    public function down(): void
    {
        // Tidak dipulihkan: tabel legacy sudah tidak digunakan.
    }
};