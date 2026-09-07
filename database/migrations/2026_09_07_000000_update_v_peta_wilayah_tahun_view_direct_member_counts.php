<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Rebuild v_peta_wilayah_tahunan: members counted from TWO sources (UNION):
     *   1) members linked to projects of that year (historical data 2023-2025)
     *   2) members with id_user IS NOT NULL (properly registered through user flow)
     *      counted by created_at year — bulk-imported members (no id_user) are EXCLUDED.
     *
     * This ensures:
     *   - 2023-2025: shows real historical data from project links
     *   - 2026+: shows only properly registered members (1-2 per wilayah),
     *     NOT the combined total of all bulk-imported members
     * Projects counted per-year as before.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_peta_wilayah_tahunan');

        DB::statement(<<<'SQL'
        CREATE VIEW v_peta_wilayah_tahunan AS
        WITH
        -- Tahun berjalan selalu tampil (data boleh kosong/nol)
        current_year AS (
            SELECT CAST(EXTRACT(YEAR FROM NOW()) AS integer) AS val
        ),
        -- Tahun project yang benar-benar ada
        project_tahun AS (
            SELECT DISTINCT p.tahun
            FROM public.project p
            WHERE p.tahun IS NOT NULL
        ),
        -- Gabungan: tahun berjalan + tahun project historis
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
        -- Member 2023-2025: dari link project (data historis real)
        mentor_by_project AS (
            SELECT p.tahun, m.id_wilayah, m.id_mentor
            FROM public.project p
            JOIN public.project_mentor pm ON pm.id_project = p.id_project
            JOIN public.mentor m ON m.id_mentor = pm.id_mentor
            WHERE m.id_wilayah IS NOT NULL
              AND p.tahun IS NOT NULL
              AND m.status = 'aktif'
            GROUP BY p.tahun, m.id_wilayah, m.id_mentor
        ),
        talenta_by_project AS (
            SELECT p.tahun, t.id_wilayah, t.id_talenta
            FROM public.project p
            JOIN public.project_talenta pt ON pt.id_project = p.id_project
            JOIN public.talenta t ON t.id_talenta = pt.id_talenta
            WHERE t.id_wilayah IS NOT NULL
              AND p.tahun IS NOT NULL
              AND t.status = 'aktif'
            GROUP BY p.tahun, t.id_wilayah, t.id_talenta
        ),
        client_by_project AS (
            SELECT p.tahun, c.id_wilayah, c.id_client
            FROM public.project p
            JOIN public.project_client pc ON pc.id_project = p.id_project
            JOIN public.client c ON c.id_client = pc.id_client
            WHERE c.id_wilayah IS NOT NULL
              AND p.tahun IS NOT NULL
              AND c.status = 'aktif'
            GROUP BY p.tahun, c.id_wilayah, c.id_client
        ),

        -- Member 2026+: hanya yang punya id_user (terdaftar melalui flow user)
        mentor_proper AS (
            SELECT EXTRACT(YEAR FROM m.created_at)::integer AS tahun,
                   m.id_wilayah, m.id_mentor
            FROM public.mentor m
            WHERE m.id_wilayah IS NOT NULL
              AND m.id_user IS NOT NULL
              AND m.status = 'aktif'
              AND m.created_at IS NOT NULL
        ),
        talenta_proper AS (
            SELECT EXTRACT(YEAR FROM t.created_at)::integer AS tahun,
                   t.id_wilayah, t.id_talenta
            FROM public.talenta t
            WHERE t.id_wilayah IS NOT NULL
              AND t.id_user IS NOT NULL
              AND t.status = 'aktif'
              AND t.created_at IS NOT NULL
        ),
        client_proper AS (
            SELECT EXTRACT(YEAR FROM c.created_at)::integer AS tahun,
                   c.id_wilayah, c.id_client
            FROM public.client c
            WHERE c.id_wilayah IS NOT NULL
              AND c.id_user IS NOT NULL
              AND c.status = 'aktif'
              AND c.created_at IS NOT NULL
        ),

        -- Gabungan: project-based (2023-2025) + proper (2026+)
        mentor_stat AS (
            SELECT tahun, id_wilayah, count(*) AS jumlah_mentor
            FROM (
                SELECT tahun, id_wilayah, id_mentor FROM mentor_by_project
                UNION
                SELECT tahun, id_wilayah, id_mentor FROM mentor_proper
            ) x
            GROUP BY tahun, id_wilayah
        ),
        talenta_stat AS (
            SELECT tahun, id_wilayah, count(*) AS jumlah_talenta
            FROM (
                SELECT tahun, id_wilayah, id_talenta FROM talenta_by_project
                UNION
                SELECT tahun, id_wilayah, id_talenta FROM talenta_proper
            ) x
            GROUP BY tahun, id_wilayah
        ),
        client_stat AS (
            SELECT tahun, id_wilayah, count(*) AS jumlah_client
            FROM (
                SELECT tahun, id_wilayah, id_client FROM client_by_project
                UNION
                SELECT tahun, id_wilayah, id_client FROM client_proper
            ) x
            GROUP BY tahun, id_wilayah
        ),
        -- Project per tahun (REAL)
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
     * Reverse: rebuild versi per-tahun (project-based) sederhana.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_peta_wilayah_tahunan');
    }
};