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
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->default('public')->after('password_hash');
            }

            if (! Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo', 255)->nullable()->after('email_verified_at');
            }

            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('aktif')->after('role');
            }

            if (! Schema::hasIndex('users', 'users_role_index')) {
                $table->index('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'profile_photo', 'status']);
        });
    }
};
