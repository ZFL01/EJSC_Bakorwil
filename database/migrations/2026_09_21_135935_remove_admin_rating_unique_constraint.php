<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nama unique constraint yang hendak dihapus.
     *
     * Constraint ini hanya ada pada skema lama tabel `ratings`
     * (basis admin_id + rateable_type + rateable_id). Karena tabel
     * `ratings` yang dipakai sekarang berbasis client_id, constraint
     * tersebut bisa saja belum/tidak pernah dibuat, sehingga
     * penghapusannya wajib dicek terlebih dahulu.
     */
    private const UNIQUE_INDEX = 'ratings_admin_target_unique';

    public function up(): void
    {
        if (!Schema::hasTable('ratings')) {
            return;
        }

        if (!Schema::hasIndex('ratings', self::UNIQUE_INDEX, 'unique')) {
            return;
        }

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique(self::UNIQUE_INDEX);
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('ratings')) {
            return;
        }

        // Kolom admin_id wajib ada untuk membuat kembali constraint.
        if (!Schema::hasColumn('ratings', 'admin_id')) {
            return;
        }

        if (Schema::hasIndex('ratings', self::UNIQUE_INDEX, 'unique')) {
            return;
        }

        Schema::table('ratings', function (Blueprint $table) {
            $table->unique(
                [
                    'admin_id',
                    'rateable_type',
                    'rateable_id',
                ],
                self::UNIQUE_INDEX
            );
        });
    }
};