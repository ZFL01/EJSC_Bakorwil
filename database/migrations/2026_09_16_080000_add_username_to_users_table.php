<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Tambah kolom users.username yang selama ini diasumsikan ada oleh
     * kode (GoogleAuthController, LinkedinAuthController,
     * RegisterController, User::$fillable, tests) namun belum pernah
     * dibuat oleh migration mana pun di database lokal.
     *
     * Kolom dibuat nullable dulu agar migrate aman pada data existing,
     * lalu di-backfill dari prefix email, baru dikunci NOT NULL + UNIQUE
     * agar konsisten dengan skema produksi (lihat file dump
     * bakorwil_jember: username varchar(100) NOT NULL).
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 100)->nullable()->after('name');
            });
        }

        // Backfill user existing yang belum punya username.
        $users = DB::table('users')->whereNull('username')->get(['id_user', 'email', 'name']);
        foreach ($users as $user) {
            $base = Str::slug(explode('@', strtolower($user->email ?? ''))[0] ?? '', '') ?: 'user';
            $base = substr($base, 0, 90);

            $username = $base;
            $i = 1;
            while (DB::table('users')->where('username', $username)->exists()) {
                $username = $base.($i++);
            }

            DB::table('users')->where('id_user', $user->id_user)->update(['username' => $username]);
        }

        // Kunci NOT NULL (abaikan bila driver tidak mendukung / sudah NOT NULL).
        try {
            DB::statement('ALTER TABLE users ALTER COLUMN username SET NOT NULL');
        } catch (\Throwable $e) {
            report($e);
        }

        // UNIQUE constraint bila belum ada.
        try {
            $exists = DB::selectOne(<<<SQL
                SELECT 1
                FROM pg_constraint c
                JOIN pg_class t ON t.oid = c.conrelid
                WHERE t.relname = 'users' AND c.conname = 'users_username_unique'
            SQL);

            if (!$exists) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('username', 'users_username_unique');
                });
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_username_unique');
            $table->dropColumn('username');
        });
    }
};
