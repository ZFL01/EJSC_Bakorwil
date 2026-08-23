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
        // Get statistics using the database view
        $stats = DB::table('v_admin_dashboard_stats')->first();

        // Get recent activities from admin logs
        $recentActivities = AdminLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Upcoming kegiatans
        $upcomingKegiatans = Kegiatan::with('organizer')
            ->upcoming()
            ->latest('tanggal_kegiatan')
            ->limit(5)
            ->get();

        // Recent clients
        $recentClients = Client::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Chart data: Clients by product type
        $clientsByProduct = Client::select('nama_produk', DB::raw('count(*) as total'))
            ->where('status', 'aktif')
            ->groupBy('nama_produk')
            ->orderByDesc('total')
            ->limit(10)
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
            'recentActivities',
            'upcomingKegiatans',
            'recentClients',
            'clientsByProduct',
            'talentsByStatus',
            'mentorAvailability'
        ));
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
