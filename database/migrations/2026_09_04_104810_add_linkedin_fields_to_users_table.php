<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Google OAuth (sudah ada, tapi kita pastikan)
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('last_login');
            }

            // LinkedIn OAuth
            if (!Schema::hasColumn('users', 'linkedin_id')) {
                $table->string('linkedin_id')->nullable()->unique()->after('google_id');
            }

            if (!Schema::hasColumn('users', 'linkedin_token')) {
                $table->text('linkedin_token')->nullable()->after('linkedin_id');
            }

            if (!Schema::hasColumn('users', 'linkedin_refresh_token')) {
                $table->text('linkedin_refresh_token')->nullable()->after('linkedin_token');
            }

            // Tambahkan index untuk mempercepat pencarian
            if (!Schema::hasIndex('users', 'users_google_id_index')) {
                $table->index('google_id');
            }

            if (!Schema::hasIndex('users', 'users_linkedin_id_index')) {
                $table->index('linkedin_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus index
            if (Schema::hasIndex('users', 'users_google_id_index')) {
                $table->dropIndex('users_google_id_index');
            }

            if (Schema::hasIndex('users', 'users_linkedin_id_index')) {
                $table->dropIndex('users_linkedin_id_index');
            }

            // Hapus kolom LinkedIn
            $columns = [
                'linkedin_refresh_token',
                'linkedin_token',
                'linkedin_id',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};