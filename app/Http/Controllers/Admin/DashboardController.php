<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\Kegiatan;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        // Statistik dari database view.
        // CATATAN: kolom pada v_admin_dashboard_stats adalah total_client_aktif,
        // total_mentor_aktif, total_talenta_aktif, total_kegiatan, kegiatan_upcoming,
        // pending_changes, pending_users.
        $stats = DB::table('v_admin_dashboard_stats')->first();

        // Total seluruh data (termasuk non-aktif) untuk kartu statistik
        $totals = [
            'clients'   => Client::count(),
            'mentors'   => Mentor::count(),
            'talents'   => Talent::count(),
            'kegiatans' => Kegiatan::count(),
        ];

        // Tren pertumbuhan data 6 bulan terakhir (line chart)
        $growth = $this->monthlyGrowth();

        // Get recent activities from admin logs
        $recentActivities = AdminLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        // Upcoming kegiatans (terdekat lebih dulu) + jumlah peserta terdaftar
        $upcomingKegiatans = Kegiatan::with('organizer')
            ->upcoming()
            ->orderBy('tanggal_kegiatan')
            ->limit(5)
            ->withCount(['participantRecords as registered_count' => function ($q) {
                $q->where('status', '!=', 'cancelled');
            }])
            ->get();

        // Recent clients
        $recentClients = Client::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Chart data: Clients by product type
        $clientsByProduct = Client::select('nama_produk', DB::raw('count(*) as total'))
            ->where('status', 'aktif')
            ->whereNotNull('nama_produk')
            ->groupBy('nama_produk')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Chart data: Talents by employment status
        $talentsByStatus = Talent::select('status_pekerjaan', DB::raw('count(*) as total'))
            ->where('status', 'aktif')
            ->whereNotNull('status_pekerjaan')
            ->groupBy('status_pekerjaan')
            ->get();

        // Mentors availability
        $mentorAvailability = [
            'available' => Mentor::active()->where('is_available', true)->count(),
            'unavailable' => Mentor::active()->where('is_available', false)->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'totals',
            'growth',
            'recentActivities',
            'upcomingKegiatans',
            'recentClients',
            'clientsByProduct',
            'talentsByStatus',
            'mentorAvailability'
        ));
    }

    /**
     * Data pertumbuhan (data baru per bulan) 6 bulan terakhir
     * untuk line chart dashboard.
     */
    private function monthlyGrowth(): array
    {
        $bulanIndo = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $growth = [
            'labels'  => [],
            'mentors' => [],
            'talents' => [],
            'clients' => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $start = now()->subMonthsNoOverflow($i)->startOfMonth();
            $end   = now()->subMonthsNoOverflow($i)->endOfMonth();

            $growth['labels'][]  = $bulanIndo[(int) $start->format('n')] . ' ' . $start->format('y');
            $growth['mentors'][] = Mentor::whereBetween('created_at', [$start, $end])->count();
            $growth['talents'][] = Talent::whereBetween('created_at', [$start, $end])->count();
            $growth['clients'][] = Client::whereBetween('created_at', [$start, $end])->count();
        }

        return $growth;
    }

    /**
     * Get statistics for API/AJAX requests.
     */
    public function getStats()
    {
        $stats = DB::table('v_admin_dashboard_stats')->first();

        return response()->json($stats);
    }

    /**
     * Get activity logs with filters.
     */
    public function activityLogs(Request $request)
    {
        $query = AdminLog::with('user');

        if ($request->filled('table_name')) {
            $query->forTable($request->table_name);
        }

        if ($request->filled('action')) {
            $query->forAction($request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('id_user', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(20);

        return view('admin.activity-logs', compact('logs'));
    }
}
