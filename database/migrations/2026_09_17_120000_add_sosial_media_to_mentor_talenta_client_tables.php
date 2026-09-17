<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom sosial media & perizinan yang dipakai form admin/profil:
     * - mentor.sosial_media
     * - talenta.sosial_media
     * - client.sosial_media + client.perizinan
     */
    public function up(): void
    {
        Schema::table('mentor', function (Blueprint $table) {
            $table->string('sosial_media', 500)->nullable()->after('portofolio_url');
        });

        Schema::table('talenta', function (Blueprint $table) {
            $table->string('sosial_media', 500)->nullable()->after('portofolio_url');
        });

        Schema::table('client', function (Blueprint $table) {
            $table->string('sosial_media', 500)->nullable()->after('website');
            $table->string('perizinan', 100)->nullable()->after('sosial_media');
        });
    }

    public function down(): void
    {
        Schema::table('mentor', function (Blueprint $table) {
            $table->dropColumn('sosial_media');
        });

        Schema::table('talenta', function (Blueprint $table) {
            $table->dropColumn('sosial_media');
        });

        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn(['sosial_media', 'perizinan']);
        });
    }
};
