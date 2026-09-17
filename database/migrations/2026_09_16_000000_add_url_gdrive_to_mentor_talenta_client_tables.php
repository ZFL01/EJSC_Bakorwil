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
        foreach (['mentor', 'talenta', 'client'] as $table) {
            if (! Schema::hasColumn($table, 'url_gdrive')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('url_gdrive', 500)->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['mentor', 'talenta', 'client'] as $table) {
            if (Schema::hasColumn($table, 'url_gdrive')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('url_gdrive');
                });
            }
        }
    }
};