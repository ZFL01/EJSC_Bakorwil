<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique(
                'ratings_admin_target_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->unique(
                [
                    'admin_id',
                    'rateable_type',
                    'rateable_id',
                ],
                'ratings_admin_target_unique'
            );
        });
    }
};