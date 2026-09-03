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
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('users', 'github_id')) {
                $table->string('github_id')->nullable()->unique()->after('google_id');
            }

            if (!Schema::hasColumn('users', 'github_username')) {
                $table->string('github_username')->nullable()->after('github_id');
            }

            if (!Schema::hasColumn('users', 'github_token')) {
                $table->text('github_token')->nullable()->after('github_username');
            }

            if (!Schema::hasColumn('users', 'github_refresh_token')) {
                $table->text('github_refresh_token')->nullable()->after('github_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['github_refresh_token', 'github_token', 'github_username', 'github_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};