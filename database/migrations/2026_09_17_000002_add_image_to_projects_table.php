<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel `project` adalah tabel legacy dari dump/import SQL (tidak dibuat
     * oleh migration mana pun), sehingga guard hasTable dipakai agar migration
     * ini tidak gagal pada environment tanpa tabel tersebut (mis. test sqlite).
     */
    public function up(): void
    {
        if (! Schema::hasTable('project') || Schema::hasColumn('project', 'gambar')) {
            return;
        }

        Schema::table('project', function (Blueprint $table) {
            $table->string('gambar')->nullable();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('project') || ! Schema::hasColumn('project', 'gambar')) {
            return;
        }

        Schema::table('project', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
};