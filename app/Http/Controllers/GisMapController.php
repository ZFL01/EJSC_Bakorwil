<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GisMapController extends Controller
{
    /**
     * Nilai parameter `tahun` yang dipakai frontend untuk meminta
     * akumulasi SELURUH tahun (bukan satu tahun tertentu).
     */
    private const ALL_YEARS_ALIASES = ['all', 'semua', 'semua-tahun', 'akumulasi'];

    public function index()
{
    return view('gis');
}
    /**
     * Daftar tahun yang tersedia pada view PostGIS.
     */
    public function years(): JsonResponse
    {
        $years = DB::table('v_peta_wilayah_tahunan')
            ->select('tahun')
            ->whereNotNull('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->map(fn ($year) => (int) $year)
            ->values();

        return response()->json($years);
    }

    /**
     * GeoJSON 7 wilayah untuk tahun tertentu.
     * Data atribut statistik ikut dikirim ke Leaflet.
     *
     * Bila parameter `tahun` diisi `all` (atau `semua`), statistik
     * diakumulasikan dari SELURUH tahun yang tersedia.
     */
    public function wilayah(Request $request): JsonResponse
    {
        if ($this->isAllYearsRequest($request)) {
            return $this->wilayahAkumulasi();
        }

        $year = $request->integer('tahun');

        if (!$year) {
            $year = (int) DB::table('v_peta_wilayah_tahunan')->max('tahun');
        }

        if (!$year) {
            return $this->featureCollection(collect());
        }

        $rows = DB::table('v_peta_wilayah_tahunan')
            ->select([
                'gid',
                'tahun',
                'id_wilayah',
                'nama_wilayah',
                'jenis_wilayah',
                'bakorwil',
                'kode_bps',
                'jumlah_project',
                'jumlah_mentor',
                'jumlah_talenta',
                'jumlah_client',
            ])
            ->selectRaw('ST_AsGeoJSON(geom) AS geometry')
            ->where('tahun', $year)
            ->orderBy('nama_wilayah')
            ->get();

        $features = $rows->map(function ($row) {
            return [
                'type' => 'Feature',
                'id' => $row->gid,
                'geometry' => $row->geometry ? json_decode($row->geometry, true) : null,
                'properties' => [
                    'gid' => $row->gid,
                    'tahun' => (int) $row->tahun,
                    'akumulasi' => false,
                    'id_wilayah' => $row->id_wilayah,
                    'nama_wilayah' => $row->nama_wilayah,
                    'jenis_wilayah' => $row->jenis_wilayah,
                    'bakorwil' => $row->bakorwil,
                    'kode_bps' => $row->kode_bps,
                    'jumlah_project' => (int) ($row->jumlah_project ?? 0),
                    'jumlah_mentor' => (int) ($row->jumlah_mentor ?? 0),
                    'jumlah_talenta' => (int) ($row->jumlah_talenta ?? 0),
                    'jumlah_client' => (int) ($row->jumlah_client ?? 0),
                ],
            ];
        })->values();

        return $this->featureCollection($features);
    }

    /**
     * GeoJSON 7 wilayah dengan statistik akumulasi SELURUH tahun.
     *
     * Angka tiap wilayah = penjumlahan nilai per tahun dari
     * v_peta_wilayah_tahunan (project, mentor, talenta, client),
     * sedangkan geometri diambil sekali dari tabel wilayah sehingga
     * tetap 7 feature (bukan 7 x jumlah tahun).
     */
    protected function wilayahAkumulasi(): JsonResponse
    {
        $rows = DB::table('wilayah as w')
            ->leftJoin('v_peta_wilayah_tahunan as v', 'v.id_wilayah', '=', 'w.id_wilayah')
            ->select([
                'w.id_wilayah',
                'w.nama_wilayah',
                'w.jenis_wilayah',
                'w.bakorwil',
                'w.kode_bps',
            ])
            ->selectRaw('ST_AsGeoJSON(w.geom) AS geometry')
            ->selectRaw('COALESCE(SUM(v.jumlah_project), 0)::bigint AS jumlah_project')
            ->selectRaw('COALESCE(SUM(v.jumlah_mentor), 0)::bigint AS jumlah_mentor')
            ->selectRaw('COALESCE(SUM(v.jumlah_talenta), 0)::bigint AS jumlah_talenta')
            ->selectRaw('COALESCE(SUM(v.jumlah_client), 0)::bigint AS jumlah_client')
            ->selectRaw('COUNT(DISTINCT v.tahun)::integer AS jumlah_tahun')
            ->selectRaw('MIN(v.tahun)::integer AS tahun_awal')
            ->selectRaw('MAX(v.tahun)::integer AS tahun_akhir')
            ->groupBy(
                'w.id_wilayah',
                'w.nama_wilayah',
                'w.jenis_wilayah',
                'w.bakorwil',
                'w.kode_bps',
                'w.geom'
            )
            ->orderBy('w.nama_wilayah')
            ->get();

        $features = $rows->map(function ($row) {
            return [
                'type' => 'Feature',
                'id' => (int) $row->id_wilayah,
                'geometry' => $row->geometry ? json_decode($row->geometry, true) : null,
                'properties' => [
                    // gid per tahun tidak relevan untuk akumulasi → pakai id_wilayah.
                    'gid' => (int) $row->id_wilayah,
                    'tahun' => null,
                    'akumulasi' => true,
                    'jumlah_tahun' => (int) ($row->jumlah_tahun ?? 0),
                    'tahun_awal' => $row->tahun_awal === null ? null : (int) $row->tahun_awal,
                    'tahun_akhir' => $row->tahun_akhir === null ? null : (int) $row->tahun_akhir,
                    'id_wilayah' => $row->id_wilayah,
                    'nama_wilayah' => $row->nama_wilayah,
                    'jenis_wilayah' => $row->jenis_wilayah,
                    'bakorwil' => $row->bakorwil,
                    'kode_bps' => $row->kode_bps,
                    'jumlah_project' => (int) ($row->jumlah_project ?? 0),
                    'jumlah_mentor' => (int) ($row->jumlah_mentor ?? 0),
                    'jumlah_talenta' => (int) ($row->jumlah_talenta ?? 0),
                    'jumlah_client' => (int) ($row->jumlah_client ?? 0),
                ],
            ];
        })->values();

        return $this->featureCollection($features, 'Bakorwil_7_Wilayah_Semua_Tahun');
    }

    /**
     * Apakah request meminta statistik akumulasi seluruh tahun.
     */
    protected function isAllYearsRequest(Request $request): bool
    {
        $tahun = $request->query('tahun');

        if (!is_string($tahun) || trim($tahun) === '') {
            return false;
        }

        return in_array(strtolower(trim($tahun)), self::ALL_YEARS_ALIASES, true);
    }

    /**
     * Bungkus features menjadi GeoJSON FeatureCollection standar.
     */
    protected function featureCollection($features, string $name = 'Bakorwil_7_Wilayah'): JsonResponse
    {
        return response()->json([
            'type' => 'FeatureCollection',
            'name' => $name,
            'crs' => [
                'type' => 'name',
                'properties' => [
                    'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84',
                ],
            ],
            'features' => $features,
        ]);
    }
}
