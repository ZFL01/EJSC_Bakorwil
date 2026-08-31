<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create the v_admin_dashboard_stats view if it does not exist yet.
     */
    public function up(): void
    {
        DB::statement(<<<'SQL'
        DO $$
        BEGIN
            IF NOT EXISTS (
                SELECT 1
                FROM pg_views
                WHERE schemaname = 'public'
                  AND viewname = 'v_admin_dashboard_stats'
            ) THEN
                CREATE VIEW v_admin_dashboard_stats AS
                SELECT
                    (SELECT COUNT(*) FROM client WHERE status = 'aktif')       AS total_client_aktif,
                    (SELECT COUNT(*) FROM mentor WHERE status = 'aktif')       AS total_mentor_aktif,
                    (SELECT COUNT(*) FROM talenta WHERE status = 'aktif')      AS total_talenta_aktif,
                    (SELECT COUNT(*) FROM kegiatan_ejsc WHERE status != 'dibatalkan') AS total_kegiatan,
                    (SELECT COUNT(*) FROM kegiatan_ejsc
                      WHERE status = 'akan_datang' AND tanggal_kegiatan > CURRENT_DATE) AS kegiatan_upcoming,
                    (SELECT COUNT(*) FROM profile_changes WHERE status = 'pending') AS pending_changes,
                    (SELECT COUNT(*) FROM users WHERE status = 'pending')      AS pending_users;
            END IF;
        END $$;
        SQL);
    }

    /**
     * Drop the view if it exists.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_admin_dashboard_stats');
    }
};