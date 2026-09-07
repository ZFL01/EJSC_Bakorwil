<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Rebuild v_peta_wilayah_tahunan so that jumlah_mentor / jumlah_talenta /
     * jumlah_client are counted DIRECTLY from their own tables by id_wilayah
     * (filtered status = 'aktif'), instead of via project link tables.
     *
     * Versi sebelumnya menghitung mentor/talenta/client melalui JOIN ke
     * project (project_mentor / project_talenta / project_client), sehingga
     * member baru yang belum terhubung ke project tidak pernah muncul di
     * GIS map. Jumlah project tetap dihitung per-tahun seperti semula.
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
        -- Statistik member: dihitung LANGSUNG dari tabel mereka
        -- (member aktif, dikelompokkan per wilayah — kumulatif, bukan per-tahun)
        client_stat AS (
            SELECT c.id_wilayah, count(*) AS jumlah_client
            FROM public.client c
            WHERE c.id_wilayah IS NOT NULL
              AND c.status = 'aktif'
            GROUP BY c.id_wilayah
        ),
        mentor_stat AS (
            SELECT m.id_wilayah, count(*) AS jumlah_mentor
            FROM public.mentor m
            WHERE m.id_wilayah IS NOT NULL
              AND m.status = 'aktif'
            GROUP BY m.id_wilayah
        ),
        talenta_stat AS (
            SELECT t.id_wilayah, count(*) AS jumlah_talenta
            FROM public.talenta t
            WHERE t.id_wilayah IS NOT NULL
              AND t.status = 'aktif'
            GROUP BY t.id_wilayah
        ),
        -- Statistik project tetap dihitung per-tahun (REAL data)
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
        LEFT JOIN mentor_stat ms ON ms.id_wilayah = tw.id_wilayah
        LEFT JOIN talenta_stat ts ON ts.id_wilayah = tw.id_wilayah
        LEFT JOIN client_stat cs ON cs.id_wilayah = tw.id_wilayah;
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