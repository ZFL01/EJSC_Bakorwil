<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GisMapController extends Controller
{
    /**
     * Nilai parameter `tahun` yang dipakai frontend untuk meminta
     * akumulasi SELURUH tahun (bukan satu tahun tertentu).
     */
    private const ALL_YEARS_ALIASES = ['all', 'semua', 'semua-tahun', 'akumulasi'];

    /**
     * Daftar tahun yang tersedia pada view PostGIS.
     *
     * Fallback: bila view/PostGIS belum tersedia (mis. DB lokal kosong),
     * baca daftar tahun unik dari file statis public/maps/bakorwil.geojson
     * agar dropdown Tahun di home tetap terisi dan tidak error.
     */
    public function years(): JsonResponse
    {
        try {
            if ($this->hasGisView()) {
                $years = DB::table('v_peta_wilayah_tahunan')
                    ->select('tahun')
                    ->whereNotNull('tahun')
                    ->distinct()
                    ->orderByDesc('tahun')
                    ->pluck('tahun')
                    ->map(fn ($year) => (int) $year)
                    ->values();

                if ($years->isNotEmpty()) {
                    return response()->json($years);
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json($this->staticYears());
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
        try {
            if ($this->isAllYearsRequest($request)) {
                return $this->wilayahAkumulasi();
            }

            return $this->wilayahSatuTahun($request->integer('tahun'));
        } catch (\Throwable $e) {
            report($e);

            if ($this->isAllYearsRequest($request)) {
                return $this->featureCollection(
                    $this->staticAkumulasiFeatures(),
                    'Bakorwil_7_Wilayah_Semua_Tahun'
                );
            }

            return $this->featureCollection(
                $this->staticFeaturesForYear($request->integer('tahun') ?: null)
            );
        }
    }

    /**
     * GeoJSON 7 wilayah untuk satu tahun tertentu.
     */
    protected function wilayahSatuTahun(int $year): JsonResponse
    {
        if ($this->hasGisView()) {
            if (!$year) {
                $year = (int) DB::table('v_peta_wilayah_tahunan')->max('tahun');
            }

            if (!$year) {
                return $this->featureCollection($this->staticFeaturesForYear(null));
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

            if ($rows->isNotEmpty()) {
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
        }

        return $this->featureCollection($this->staticFeaturesForYear($year ?: null));
    }

    /**
     * GeoJSON 7 wilayah dengan statistik akumulasi SELURUH tahun.
     * Anggota dihitung DISTINCT per wilayah (tidak ganda antar tahun).
     * Fallback ke file statis bila tabel legacy / geom belum ada.
     */
    protected function wilayahAkumulasi(): JsonResponse
    {
        try {
            if ($this->canQueryGis() && $this->hasLegacyProjectTables()) {
                $stats = $this->distinctAccumulatedStats();

                $rows = DB::table('wilayah as w')
                    ->select([
                        'w.id_wilayah',
                        'w.nama_wilayah',
                        'w.jenis_wilayah',
                        'w.bakorwil',
                        'w.kode_bps',
                    ])
                    ->selectRaw('ST_AsGeoJSON(w.geom) AS geometry')
                    ->orderBy('w.nama_wilayah')
                    ->get();

                if ($rows->isNotEmpty()) {
                    $features = $rows->map(function ($row) use ($stats) {
                        $s = $stats[(string) $row->id_wilayah] ?? [
                            'jumlah_project' => 0,
                            'jumlah_mentor' => 0,
                            'jumlah_talenta' => 0,
                            'jumlah_client' => 0,
                            'jumlah_tahun' => 0,
                            'tahun_awal' => null,
                            'tahun_akhir' => null,
                        ];

                        return [
                            'type' => 'Feature',
                            'id' => (int) $row->id_wilayah,
                            'geometry' => $row->geometry ? json_decode($row->geometry, true) : null,
                            'properties' => [
                                'gid' => (int) $row->id_wilayah,
                                'tahun' => null,
                                'akumulasi' => true,
                                'jumlah_tahun' => (int) ($s['jumlah_tahun'] ?? 0),
                                'tahun_awal' => $s['tahun_awal'] ?? null,
                                'tahun_akhir' => $s['tahun_akhir'] ?? null,
                                'id_wilayah' => $row->id_wilayah,
                                'nama_wilayah' => $row->nama_wilayah,
                                'jenis_wilayah' => $row->jenis_wilayah,
                                'bakorwil' => $row->bakorwil,
                                'kode_bps' => $row->kode_bps,
                                'jumlah_project' => (int) ($s['jumlah_project'] ?? 0),
                                'jumlah_mentor' => (int) ($s['jumlah_mentor'] ?? 0),
                                'jumlah_talenta' => (int) ($s['jumlah_talenta'] ?? 0),
                                'jumlah_client' => (int) ($s['jumlah_client'] ?? 0),
                            ],
                        ];
                    })->values();

                    return $this->featureCollection($features, 'Bakorwil_7_Wilayah_Semua_Tahun');
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return $this->featureCollection(
            $this->staticAkumulasiFeatures(),
            'Bakorwil_7_Wilayah_Semua_Tahun'
        );
    }

    /**
     * Statistik akumulasi DISTINCT per wilayah dari tabel dasar.
     * UNION membuang duplikat pasangan (id_wilayah, id) yang sama.
     */
    protected function distinctAccumulatedStats(): array
    {
        $mentorLinked = DB::table('project as p')
            ->join('project_mentor as pm', 'pm.id_project', '=', 'p.id_project')
            ->join('mentor as m', 'm.id_mentor', '=', 'pm.id_mentor')
            ->whereNotNull('m.id_wilayah')
            ->where('m.status', 'aktif')
            ->select('m.id_wilayah', 'm.id_mentor as id_anggota');

        $mentorProper = DB::table('mentor as m')
            ->whereNotNull('m.id_wilayah')
            ->whereNotNull('m.id_user')
            ->where('m.status', 'aktif')
            ->select('m.id_wilayah', 'm.id_mentor as id_anggota');

        $mentorCounts = DB::query()
            ->fromSub($mentorLinked->union($mentorProper), 'x')
            ->select('id_wilayah')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('id_wilayah')
            ->pluck('total', 'id_wilayah');

        $talentaLinked = DB::table('project as p')
            ->join('project_talenta as pt', 'pt.id_project', '=', 'p.id_project')
            ->join('talenta as t', 't.id_talenta', '=', 'pt.id_talenta')
            ->whereNotNull('t.id_wilayah')
            ->where('t.status', 'aktif')
            ->select('t.id_wilayah', 't.id_talenta as id_anggota');

        $talentaProper = DB::table('talenta as t')
            ->whereNotNull('t.id_wilayah')
            ->whereNotNull('t.id_user')
            ->where('t.status', 'aktif')
            ->select('t.id_wilayah', 't.id_talenta as id_anggota');

        $talentaCounts = DB::query()
            ->fromSub($talentaLinked->union($talentaProper), 'x')
            ->select('id_wilayah')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('id_wilayah')
            ->pluck('total', 'id_wilayah');

        $clientLinked = DB::table('project as p')
            ->join('project_client as pc', 'pc.id_project', '=', 'p.id_project')
            ->join('client as c', 'c.id_client', '=', 'pc.id_client')
            ->whereNotNull('c.id_wilayah')
            ->where('c.status', 'aktif')
            ->select('c.id_wilayah', 'c.id_client as id_anggota');

        $clientProper = DB::table('client as c')
            ->whereNotNull('c.id_wilayah')
            ->whereNotNull('c.id_user')
            ->where('c.status', 'aktif')
            ->select('c.id_wilayah', 'c.id_client as id_anggota');

        $clientCounts = DB::query()
            ->fromSub($clientLinked->union($clientProper), 'x')
            ->select('id_wilayah')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('id_wilayah')
            ->pluck('total', 'id_wilayah');

        $projClient = DB::table('project_client as pc')
            ->join('client as c', 'c.id_client', '=', 'pc.id_client')
            ->whereNotNull('c.id_wilayah')
            ->select('pc.id_project', 'c.id_wilayah');

        $projMentor = DB::table('project_mentor as pm')
            ->join('mentor as m', 'm.id_mentor', '=', 'pm.id_mentor')
            ->whereNotNull('m.id_wilayah')
            ->select('pm.id_project', 'm.id_wilayah');

        $projTalenta = DB::table('project_talenta as pt')
            ->join('talenta as t', 't.id_talenta', '=', 'pt.id_talenta')
            ->whereNotNull('t.id_wilayah')
            ->select('pt.id_project', 't.id_wilayah');

        $projectCounts = DB::query()
            ->fromSub($projClient->union($projMentor)->union($projTalenta), 'x')
            ->select('id_wilayah')
            ->selectRaw('COUNT(DISTINCT id_project) AS total')
            ->groupBy('id_wilayah')
            ->pluck('total', 'id_wilayah');

        $tahunInfo = ['jumlah_tahun' => 0, 'tahun_awal' => null, 'tahun_akhir' => null];
        try {
            if ($this->hasGisView()) {
                $tahunInfo = [
                    'jumlah_tahun' => (int) DB::table('v_peta_wilayah_tahunan')->distinct()->count('tahun'),
                    'tahun_awal' => ($v = DB::table('v_peta_wilayah_tahunan')->min('tahun')) === null ? null : (int) $v,
                    'tahun_akhir' => ($v = DB::table('v_peta_wilayah_tahunan')->max('tahun')) === null ? null : (int) $v,
                ];
            }
        } catch (\Throwable $e) {
            report($e);
        }

        $stats = [];
        foreach ([$mentorCounts, $talentaCounts, $clientCounts, $projectCounts] as $col) {
            foreach ($col->keys() as $id) {
                $stats[(string) $id] = $stats[(string) $id] ?? [
                    'jumlah_project' => 0, 'jumlah_mentor' => 0,
                    'jumlah_talenta' => 0, 'jumlah_client' => 0,
                    'jumlah_tahun' => $tahunInfo['jumlah_tahun'],
                    'tahun_awal' => $tahunInfo['tahun_awal'],
                    'tahun_akhir' => $tahunInfo['tahun_akhir'],
                ];
            }
        }
        foreach ($mentorCounts as $id => $v) {
            $stats[(string) $id]['jumlah_mentor'] = (int) $v;
        }
        foreach ($talentaCounts as $id => $v) {
            $stats[(string) $id]['jumlah_talenta'] = (int) $v;
        }
        foreach ($clientCounts as $id => $v) {
            $stats[(string) $id]['jumlah_client'] = (int) $v;
        }
        foreach ($projectCounts as $id => $v) {
            $stats[(string) $id]['jumlah_project'] = (int) $v;
        }

        return $stats;
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
     * Apakah view PostGIS tersedia di database saat ini.
     */
    protected function hasGisView(): bool
    {
        try {
            return DB::selectOne("SELECT to_regclass('public.v_peta_wilayah_tahunan') AS c")->c !== null;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Apakah tabel wilayah punya kolom geometri PostGIS.
     */
    protected function canQueryGis(): bool
    {
        try {
            return $this->hasGisView() && Schema::hasColumn('wilayah', 'geom');
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Apakah tabel-tabel legacy project tersedia.
     */
    protected function hasLegacyProjectTables(): bool
    {
        try {
            foreach (['project', 'project_mentor', 'project_talenta', 'project_client', 'mentor', 'talenta', 'client'] as $table) {
                if (!Schema::hasTable($table)) {
                    return false;
                }
            }

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Daftar tahun unik (desc) dari file statis.
     *
     * @return array<int>
     */
    protected function staticYears(): array
    {
        $years = [];
        foreach ($this->staticFileFeatures() as $feature) {
            $tahun = $feature['properties']['tahun'] ?? null;
            if (is_numeric($tahun)) {
                $years[(int) $tahun] = true;
            }
        }
        $years = array_keys($years);
        rsort($years);

        return $years;
    }

    /**
     * Feature satu tahun dari file statis (null = tahun terbaru).
     */
    protected function staticFeaturesForYear(?int $year): array
    {
        $features = $this->staticFileFeatures();
        if (empty($features)) {
            return [];
        }
        if (!$year) {
            $years = $this->staticYears();
            $year = $years[0] ?? null;
        }
        if (!$year) {
            return [];
        }

        return array_values(array_filter(
            $features,
            fn ($f) => (int) ($f['properties']['tahun'] ?? 0) === (int) $year
        ));
    }

    /**
     * Feature akumulasi (dijumlahkan per wilayah) dari file statis.
     */
    protected function staticAkumulasiFeatures(): array
    {
        $grouped = [];
        foreach ($this->staticFileFeatures() as $feature) {
            $props = $feature['properties'] ?? [];
            $idWilayah = $props['id_wilayah'] ?? null;
            if ($idWilayah === null) {
                continue;
            }
            $key = (string) $idWilayah;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'feature' => $feature, 'tahun' => [],
                    'jumlah_project' => 0, 'jumlah_mentor' => 0,
                    'jumlah_talenta' => 0, 'jumlah_client' => 0,
                ];
            }
            if (is_numeric($props['tahun'] ?? null)) {
                $grouped[$key]['tahun'][(int) $props['tahun']] = true;
            }
            $grouped[$key]['jumlah_project'] += (int) ($props['jumlah_project'] ?? 0);
            $grouped[$key]['jumlah_mentor'] += (int) ($props['jumlah_mentor'] ?? 0);
            $grouped[$key]['jumlah_talenta'] += (int) ($props['jumlah_talenta'] ?? 0);
            $grouped[$key]['jumlah_client'] += (int) ($props['jumlah_client'] ?? 0);
        }

        $result = [];
        foreach ($grouped as $key => $group) {
            $props = $group['feature']['properties'] ?? [];
            $tahunList = array_keys($group['tahun']);
            sort($tahunList);
            $result[] = [
                'type' => 'Feature',
                'id' => (int) $key,
                'geometry' => $group['feature']['geometry'] ?? null,
                'properties' => array_merge($props, [
                    'gid' => (int) $key,
                    'tahun' => null,
                    'akumulasi' => true,
                    'jumlah_tahun' => count($tahunList),
                    'tahun_awal' => $tahunList[0] ?? null,
                    'tahun_akhir' => $tahunList ? end($tahunList) : null,
                    'jumlah_project' => $group['jumlah_project'],
                    'jumlah_mentor' => $group['jumlah_mentor'],
                    'jumlah_talenta' => $group['jumlah_talenta'],
                    'jumlah_client' => $group['jumlah_client'],
                ]),
            ];
        }
        usort($result, fn ($a, $b) => strcmp(
            (string) ($a['properties']['nama_wilayah'] ?? ''),
            (string) ($b['properties']['nama_wilayah'] ?? '')
        ));

        return $result;
    }

    /**
     * Baca mentah features dari file statis (di-cache per request).
     */
    protected function staticFileFeatures(): array
    {
        static $cached = null;
        if ($cached !== null) {
            return $cached;
        }
        $cached = [];
        try {
            $path = public_path('maps/bakorwil.geojson');
            if (!is_file($path)) {
                return $cached;
            }
            $decoded = json_decode((string) file_get_contents($path), true);
            if (is_array($decoded['features'] ?? null)) {
                foreach ($decoded['features'] as $feature) {
                    if (is_array($feature)) {
                        $feature['properties']['akumulasi'] = false;
                        $cached[] = $feature;
                    }
                }
            }
        } catch (\Throwable $e) {
            report($e);
            $cached = [];
        }

        return $cached;
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
