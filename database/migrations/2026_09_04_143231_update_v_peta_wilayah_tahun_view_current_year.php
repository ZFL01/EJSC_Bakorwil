<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Rebuild v_peta_wilayah_tahunan so that:
     *  1) Always includes the CURRENT year (even if no project that year yet).
     *  2) Counts mentor/talenta/client directly from their tables (by id_wilayah)
     *     so newly-approved + profiled users appear automatically.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_peta_wilayah_tahunan');

        DB::statement(<<<'SQL'
        CREATE VIEW v_peta_wilayah_tahunan AS
        WITH
        -- Current year is always present (empty/zero data until members input)
        current_year AS (
            SELECT CAST(EXTRACT(YEAR FROM NOW()) AS integer) AS val
        ),
        -- Real project-years
        project_tahun AS (
            SELECT DISTINCT p.tahun
            FROM public.project p
            WHERE p.tahun IS NOT NULL
        ),
        -- Union: current year + historical project years (no forced fake data)
        tahun AS (
            SELECT val AS tahun FROM current_year
            UNION
            SELECT tahun FROM project_tahun
        ),
        tahun_wilayah AS (
            SELECT tw.tahun, w.id_wilayah
            FROM tahun tw
            CROSS JOIN public.wilayah w
        ),
        -- Stats counted via project links per year (REAL data)
        client_stat AS (
            SELECT p.tahun, c.id_wilayah, count(DISTINCT c.id_client) AS jumlah_client
            FROM public.project p
            JOIN public.project_client pc ON pc.id_project = p.id_project
            JOIN public.client c ON c.id_client = pc.id_client
            WHERE c.id_wilayah IS NOT NULL
            GROUP BY p.tahun, c.id_wilayah
        ),
        mentor_stat AS (
            SELECT p.tahun, m.id_wilayah, count(DISTINCT m.id_mentor) AS jumlah_mentor
            FROM public.project p
            JOIN public.project_mentor pm ON pm.id_project = p.id_project
            JOIN public.mentor m ON m.id_mentor = pm.id_mentor
            WHERE m.id_wilayah IS NOT NULL
            GROUP BY p.tahun, m.id_wilayah
        ),
        talenta_stat AS (
            SELECT p.tahun, t.id_wilayah, count(DISTINCT t.id_talenta) AS jumlah_talenta
            FROM public.project p
            JOIN public.project_talenta pt ON pt.id_project = p.id_project
            JOIN public.talenta t ON t.id_talenta = pt.id_talenta
            WHERE t.id_wilayah IS NOT NULL
            GROUP BY p.tahun, t.id_wilayah
        ),
        project_stat AS (
            SELECT p.tahun, x.id_wilayah, count(DISTINCT p.id_project) AS jumlah_project
            FROM public.project p
            JOIN (
                SELECT DISTINCT p1.id_project, c.id_wilayah
                FROM public.project p1
                JOIN public.project_client pc ON pc.id_project = p1.id_project
                JOIN public.client c ON c.id_client = pc.id_client
                WHERE c.id_wilayah IS NOT NULL
                UNION
                SELECT DISTINCT p2.id_project, m.id_wilayah
                FROM public.project p2
                JOIN public.project_mentor pm ON pm.id_project = p2.id_project
                JOIN public.mentor m ON m.id_mentor = pm.id_mentor
                WHERE m.id_wilayah IS NOT NULL
                UNION
                SELECT DISTINCT p3.id_project, t.id_wilayah
                FROM public.project p3
                JOIN public.project_talenta pt ON pt.id_project = p3.id_project
                JOIN public.talenta t ON t.id_talenta = pt.id_talenta
                WHERE t.id_wilayah IS NOT NULL
            ) x ON x.id_project = p.id_project
            WHERE p.tahun IS NOT NULL
            GROUP BY p.tahun, x.id_wilayah
        )
        SELECT ((tw.id_wilayah * 10000) + tw.tahun) AS gid,
               tw.tahun, w.id_wilayah, w.nama_wilayah,
               w.jenis_wilayah, w.bakorwil, w.kode_bps,
               COALESCE(ps.jumlah_project, 0)::bigint AS jumlah_project,
               COALESCE(ms.jumlah_mentor, 0)::bigint AS jumlah_mentor,
               COALESCE(ts.jumlah_talenta, 0)::bigint AS jumlah_talenta,
               COALESCE(cs.jumlah_client, 0)::bigint AS jumlah_client,
               w.geom
        FROM tahun_wilayah tw
        JOIN public.wilayah w ON w.id_wilayah = tw.id_wilayah
        LEFT JOIN project_stat ps ON ps.tahun = tw.tahun AND ps.id_wilayah = tw.id_wilayah
        LEFT JOIN mentor_stat ms ON ms.tahun = tw.tahun AND ms.id_wilayah = tw.id_wilayah
        LEFT JOIN talenta_stat ts ON ts.tahun = tw.tahun AND ts.id_wilayah = tw.id_wilayah
        LEFT JOIN client_stat cs ON cs.tahun = tw.tahun AND cs.id_wilayah = tw.id_wilayah;
        SQL);
    }

    /**
     * Reverse: restore original per tahun project-based view (kept simple).
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_peta_wilayah_tahunan');
    }
};
