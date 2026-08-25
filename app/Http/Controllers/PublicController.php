<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\Kegiatan;
use App\Models\KegiatanParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    /**
     * Display the public home page.
     */
    public function index()
    {
        $stats = [
            'clients' => Client::active()->count(),
            'mentors' => Mentor::active()->count(),
            'talents' => Talent::active()->count(),
            'kegiatans' => Kegiatan::public()->upcoming()->count(),
        ];

        $upcomingKegiatans = Kegiatan::public()
            ->upcoming()
            ->latest('tanggal_kegiatan')
            ->limit(3)
            ->get();

        return view('home', compact('stats', 'upcomingKegiatans'));
    }

    /**
     * Display the "Tentang Kami" page with real platform statistics.
     */
    public function tentangKami()
    {
        $statistik = [
            'mentor'   => Mentor::active()->count(),
            'talenta'  => Talent::active()->count(),
            'client'   => Client::active()->count(),
            'kegiatan' => Kegiatan::public()->upcoming()->count(),
        ];

        // Pertumbuhan platform: jumlah kumulatif data per bulan (8 bulan terakhir)
        $namaBulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulan = collect(range(7, 0))->map(fn ($i) => [
            'key'   => now()->copy()->subMonths($i)->format('Y-m'),
            'label' => $namaBulan[(int) now()->copy()->subMonths($i)->format('n')],
        ]);

        $pertumbuhan = [
            'labels'  => $bulan->pluck('label')->all(),
            'mentor'  => $this->kumulatifPerBulan('mentor', $bulan->pluck('key')->all()),
            'talenta' => $this->kumulatifPerBulan('talenta', $bulan->pluck('key')->all()),
            'client'  => $this->kumulatifPerBulan('client', $bulan->pluck('key')->all()),
        ];

        // Distribusi berdasarkan kategori keahlian (diambil dari field keahlian)
        $distribusiTalenta = $this->topKeahlian(Talent::query());
        $distribusiMentor  = $this->topKeahlian(Mentor::query());

        return view('tentang-kami', compact(
            'statistik',
            'pertumbuhan',
            'distribusiTalenta',
            'distribusiMentor'
        ));
    }

    /**
     * Jumlah kumulatif record per bulan berdasarkan created_at.
     *
     * @param  array<int, string>  $bulanKeys
     * @return array<int, int>
     */
    private function kumulatifPerBulan(string $table, array $bulanKeys): array
    {
        $perBulan = DB::table($table)
            ->whereNotNull('created_at')
            ->selectRaw("to_char(created_at, 'YYYY-MM') as bulan, count(*) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $jumlah = 0;

        return collect($bulanKeys)->map(function ($key) use ($perBulan, &$jumlah) {
            $jumlah += (int) ($perBulan[$key] ?? 0);

            return $jumlah;
        })->all();
    }

    /**
     * Top kategori keahlian dari field keahlian (dipisahkan koma/titik koma).
     *
     * @return array{labels: array<int, string>, data: array<int, int>}
     */
    private function topKeahlian($query, int $limit = 5): array
    {
        $jumlah = $query->toBase()
            ->whereNotNull('keahlian')
            ->where('keahlian', '!=', '')
            ->pluck('keahlian')
            ->flatMap(fn ($v) => preg_split('/[,;]+/u', $v))
            ->map(fn ($v) => trim($v))
            ->filter(fn ($v) => $v !== '')
            ->countBy()
            ->sortDesc()
            ->take($limit);

        return [
            'labels' => $jumlah->keys()->all(),
            'data'   => $jumlah->values()->all(),
        ];
    }

    /**
     * Display a listing of clients (public view).
     */
    public function clients(Request $request)
    {
        $query = Client::publicData()->active();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_ukm', 'ILIKE', "%{$search}%")
                  ->orWhere('nama_produk', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('nama_produk')) {
            $query->where('nama_produk', 'ILIKE', "%{$request->nama_produk}%");
        }

        $clients = $query->latest()->paginate(12);

        return view('public.clients', compact('clients'));
    }

    /**
     * Display a single client (public view).
     */
    public function clientShow(Client $client)
    {
        // Only show active clients
        if ($client->status !== 'aktif') {
            abort(404);
        }

        // Use public scope to hide sensitive data
        $client = Client::publicData()
            ->where('id_client', $client->id_client)
            ->firstOrFail();

        return view('public.client-show', compact('client'));
    }

    /**
     * Display a listing of mentors (public view).
     */
    public function mentors(Request $request)
    {
        $query = Mentor::publicData()->active();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'ILIKE', "%{$search}%")
                  ->orWhere('keahlian', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('keahlian')) {
            $query->where('keahlian', 'ILIKE', "%{$request->keahlian}%");
        }

        if ($request->filled('is_available')) {
            $query->where('is_available', $request->is_available === '1');
        }

        $mentors = $query->latest()->paginate(12);

        return view('public.mentors', compact('mentors'));
    }

    /**
     * Display a single mentor (public view).
     */
    public function mentorShow(Mentor $mentor)
    {
        if ($mentor->status !== 'aktif') {
            abort(404);
        }

        $mentor = Mentor::publicData()
            ->where('id_mentor', $mentor->id_mentor)
            ->firstOrFail();

        return view('public.mentor-show', compact('mentor'));
    }

    /**
     * Display a listing of talents (public view).
     */
    public function talents(Request $request)
    {
        $query = Talent::publicData()->active();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'ILIKE', "%{$search}%")
                  ->orWhere('keahlian', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('keahlian')) {
            $query->where('keahlian', 'ILIKE', "%{$request->keahlian}%");
        }

        if ($request->filled('status_pekerjaan')) {
            $query->where('status_pekerjaan', $request->status_pekerjaan);
        }

        $talents = $query->latest()->paginate(12);

        return view('public.talents', compact('talents'));
    }

    /**
     * Display a single talent (public view).
     */
    public function talentShow(Talent $talent)
    {
        if ($talent->status !== 'aktif') {
            abort(404);
        }

        $talent = Talent::publicData()
            ->where('id_talenta', $talent->id_talenta)
            ->with('mentor:id_mentor,nama,keahlian')
            ->firstOrFail();

        return view('public.talent-show', compact('talent'));
    }

    /**
     * Display a listing of public kegiatans.
     */
    public function kegiatans(Request $request)
    {
        $this->authorize('viewAny', Kegiatan::class);

        $query = Kegiatan::public()->with('organizer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul_kegiatan', 'ILIKE', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Default to upcoming kegiatans
        if (!$request->filled('show_past')) {
            $query->upcoming();
        }

        $kegiatans = $query->latest('tanggal_kegiatan')->paginate(12);

        return view('public.kegiatans', compact('kegiatans'));
    }

    /**
     * Display a single kegiatan.
     */
    public function kegiatanShow(Kegiatan $kegiatan)
    {
        $this->authorize('view', $kegiatan);

        $kegiatan->load('organizer');

        $isRegistered = false;
        $userParticipation = null;

        if (auth()->check()) {
            $userParticipation = KegiatanParticipant::where('id_kegiatan', $kegiatan->id_kegiatan)
                ->where('id_user', auth()->id())
                ->first();
            
            $isRegistered = $userParticipation !== null;
        }

        $availableSlots = $kegiatan->hasAvailableSlots();
        $participantCount = $kegiatan->participants()
            ->wherePivot('status', '!=', 'cancelled')
            ->count();

        return view('public.kegiatan-show', compact(
            'kegiatan', 
            'isRegistered', 
            'userParticipation',
            'availableSlots',
            'participantCount'
        ));
    }

    /**
     * Register for a kegiatan.
     */
    public function kegiatanRegister(Request $request, Kegiatan $kegiatan)
    {
        $this->authorize('register', $kegiatan);

        if (!$kegiatan->hasAvailableSlots()) {
            return back()->with('error', 'Maaf, kegiatan ini sudah penuh.');
        }

        // Check if already registered
        $existing = KegiatanParticipant::where('id_kegiatan', $kegiatan->id_kegiatan)
            ->where('id_user', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar untuk kegiatan ini.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        KegiatanParticipant::create([
            'id_kegiatan' => $kegiatan->id_kegiatan,
            'id_user' => auth()->id(),
            'status' => 'registered',
            'registered_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari admin.');
    }

    /**
     * Cancel kegiatan registration.
     */
    public function kegiatanCancel(Kegiatan $kegiatan)
    {
        $participation = KegiatanParticipant::where('id_kegiatan', $kegiatan->id_kegiatan)
            ->where('id_user', auth()->id())
            ->firstOrFail();

        if ($participation->status === 'attended') {
            return back()->with('error', 'Tidak dapat membatalkan pendaftaran yang sudah hadir.');
        }

        $participation->cancel();

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
