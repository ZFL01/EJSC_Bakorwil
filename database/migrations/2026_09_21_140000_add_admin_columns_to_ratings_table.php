<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Melengkapi kolom tabel `ratings` yang dipakai fitur rating Admin
     * (App\Http\Controllers\Admin\RatingController).
     *
     * - admin_id   : admin yang membuat rating (null jika rating dari Client)
     * - rater_name : nama pemberi rating yang diinput manual oleh Admin
     * - client_id  : dibuat nullable karena rating dari Admin tidak punya client
     */
    public function up(): void
    {
        if (!Schema::hasTable('ratings')) {
            return;
        }

        Schema::table('ratings', function (Blueprint $table) {
            if (!Schema::hasColumn('ratings', 'admin_id')) {
                // Admin yang membuat rating
                $table->unsignedBigInteger('admin_id')
                    ->nullable();
            }

            if (!Schema::hasColumn('ratings', 'rater_name')) {
                // Nama pemberi rating yang diinput Admin
                $table->string('rater_name', 150)
                    ->nullable();
            }
        });

        if (Schema::hasColumn('ratings', 'client_id')) {
            // Rating dari Client boleh tanpa admin, dan rating dari
            // Admin tidak memiliki client_id → client_id harus nullable.
            Schema::table('ratings', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id')
                    ->nullable()
                    ->change();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('ratings')) {
            return;
        }

        Schema::table('ratings', function (Blueprint $table) {
            if (Schema::hasColumn('ratings', 'rater_name')) {
                $table->dropColumn('rater_name');
            }

            if (Schema::hasColumn('ratings', 'admin_id')) {
                $table->dropColumn('admin_id');
            }
        });
    }
};
