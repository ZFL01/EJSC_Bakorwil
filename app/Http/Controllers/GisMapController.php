<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GisMapController extends Controller
{
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
     */
    public function wilayah(Request $request): JsonResponse
    {
        $year = $request->integer('tahun');

        if (!$year) {
            $year = (int) DB::table('v_peta_wilayah_tahunan')->max('tahun');
        }

        if (!$year) {
            return response()->json([
                'type' => 'FeatureCollection',
                'features' => [],
            ]);
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

        return response()->json([
            'type' => 'FeatureCollection',
            'name' => 'Bakorwil_7_Wilayah',
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
