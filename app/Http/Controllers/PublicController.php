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
     * Display the public Mentor menu (data dari tabel "mentor").
     *
     * Data diambil dari database lalu dipetakan ke bentuk yang
     * dibaca oleh JavaScript renderer di resources/views/mentor.blade.php
     * (field: nama, keahlian, pengalaman, avatar, bidang).
     */
    public function mentor()
    {
        $mentors = Mentor::query()
            ->where('status', 'aktif')
            ->where('is_public', true)
            ->orderBy('nama')
            ->get()
            ->filter(function ($m) {
                // Buang data rusak/placeholder yang tidak hanya nama (mis. "11.0").
                return !$this->isJunkName($m->nama);
            })
            ->map(function ($m) {
                $nama = $m->nama ?: 'Mentor';

                // Kategori diturunkan DARI DATA NYATA yang ada di tabel mentor.
                $kataKunci = trim(implode(' ', [
                    $m->keahlian,
                    $m->pengalaman,
                    $m->domisili,
                ]));

                $kategori = $this->kategoriMentor($kataKunci);

                return [
                    'nama'        => $nama,
                    // nilai kategori yang dipilih renderer + filter (dari data nyata)
                    'keahlian'    => $kategori['key'],
                    'bidangLabel' => $kategori['label'],
                    'bidangColor' => $kategori['color'],
                    // nilai mentah dari DB (untuk popup): kosong apabila belum diisi
                    'keahlianRaw' => $m->keahlian ?: '',
                    'pengalaman'  => $m->pengalaman ?: '',
                    'domisili'    => $m->domisili ?: '',
                    'avatar'      => $this->avatarInitials($nama),
                ];
            })
            ->values();

        // Filter & badge hanya memakai kategori yang benar-benar muncul di data.
        $kategoriMentor = $this->countKategori($mentors,
            'keahlian', 'bidangLabel', 'bidangColor');

        return view('mentor', compact('mentors', 'kategoriMentor'));
    }

    /**
     * Display the public Talenta listing (data dari tabel "talenta").
     *
     * Field yang dibaca renderer: nama, keahlian, skill, level, avatar.
     */
    public function talenta()
    {
        $talentas = Talent::query()
            ->where('status', 'aktif')
            ->where('is_public', true)
            ->orderBy('nama')
            ->get()
            ->filter(function ($t) {
                // Buang data rusak/placeholder (nama hanya angka / kosong).
                return !$this->isJunkName($t->nama);
            })
            ->map(function ($t) {
                $nama = $t->nama ?: 'Talenta';

                // Kategori diturunkan dari DATA NYATA (bidang_pekerjaan / keahlian),
                // bukan label default. Jika kosong -> masuk bucket "Belum Diisi".
                $skill = $t->keahlian
                    ?: ($t->bidang_pekerjaan ?: '');

                $kataKunci = implode(' ', [
                    $t->keahlian,
                    $t->bidang_pekerjaan,
                    $t->pengalaman,
                ]);

                $kategori = $this->kategoriTalenta($kataKunci);

                return [
                    'nama'      => $nama,
                    // nilai kategori yang dipilih renderer + filter (dari data nyata)
                    'keahlian'  => $kategori['key'],
                    'katLabel'  => $kategori['label'],
                    'katColor'  => $kategori['color'],
                    // nilai mentah dari DB (untuk popup): kosong apabila belum diisi
                    'skill'     => $skill ?: '',
                    'bidang'    => $t->bidang_pekerjaan ?: '',
                    'level'     => $this->classifyLevel($t->pengalaman, $t->status_pekerjaan),
                    'domisili'  => $t->domisili ?: '',
                    'avatar'    => $this->avatarInitials($nama),
                ];
            })
            ->values();

        // Filter & badge hanya memakai kategori yang benar-benar muncul di data.
        $kategoriTalenta = $this->countKategori($talentas,
            'keahlian', 'katLabel', 'katColor');

        return view('talenta', compact('talentas', 'kategoriTalenta'));
    }

    /**
     * Display the public data listing Client (data dari tabel "client").
     *
     * Field yang dibaca renderer: nama, kategori, industri, proyek, avatar.
     */
    public function client()
    {
        $projectCounts = DB::table('project_client')
            ->selectRaw('id_client, count(*) as total')
            ->groupBy('id_client')
            ->pluck('total', 'id_client');

        $clients = Client::query()
            ->where('status', 'aktif')
            ->where('is_public', true)
            ->orderBy('nama_ukm')
            ->get()
            ->filter(function ($c) {
                // Buang data rusak/placeholder (nama hanya angka / kosong).
                return !$this->isJunkName($c->nama_ukm);
            })
            ->map(function ($c) use ($projectCounts) {
                $nama = $c->nama_ukm ?: 'Client';

                // Kategori diturunkan dari DATA NYATA (nama_ukm / nama_produk /
                // deskripsi / website / domisili). Mayoritas besar = UMKM.
                $kataKunci = implode(' ', [
                    $c->nama_ukm,
                    $c->nama_produk,
                    $c->deskripsi_usaha,
                    $c->website,
                    $c->domisili,
                ]);

                $kategori = $this->kategoriClient($kataKunci);

                return [
                    'nama'          => $nama,
                    // kategori pilihan renderer + filter (dari data nyata)
                    'kategori'      => $kategori['key'],
                    'katLabel'      => $kategori['label'],
                    'katColor'      => $kategori['color'],
                    // nilai mentah dari DB (untuk popup): kosong apabila belum diisi
                    'industri'      => $c->nama_produk ?: '',
                    'proyek'        => (int) ($projectCounts[$c->id_client] ?? 0),
                    'domisili'      => $c->domisili ?: '',
                    'deskripsi'     => $c->deskripsi_usaha ?: '',
                    'website'       => $c->website ?: '',
                    'namaProduk'    => $c->nama_produk ?: '',
                    'avatar'        => $this->avatarInitials($nama),
                ];
            })
            ->values();

        // Filter & badge hanya memakai kategori yang benar-benar muncul di data.
        $kategoriClient = $this->countKategori($clients,
            'kategori', 'katLabel', 'katColor');

        return view('client', compact('clients', 'kategoriClient'));
    }

    /**
     * Ubah sebuah nama menjadi 2 huruf inisial (mis. "Budi Santoso" -> "BS").
     */
    private function avatarInitials(?string $name): string
    {
        $words = preg_split('/\s+/u', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY);
        $initials = '';

        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }

        return $initials !== '' ? $initials : '?';
    }

    /**
     * Deteksi apakah sebuah nama "rusak"/placeholder, misalnya kosong
     * atau hanya berisi angka/tanda baca (contoh: "11.0", "28.0").
     */
    private function isJunkName(?string $name): bool
    {
        $n = trim((string) $name);

        if ($n === '') {
            return true;
        }

        // Nama hanya terdiri dari angka, titik, koma, atau spasi -> dianggap rusak.
        return (bool) preg_match('/^[0-9.,\s]+$/', $n);
    }

    /**
     * Pilih kategori Mentor berdasarkan teks yang BENAR-BENAR terisi di DB.
     * Jika tidak ada data -> bucket "Umum" (bukan asal "teknologi").
     *
     * @return array{key:string,label:string,color:string}
     */
    private function kategoriMentor(string $text): array
    {
        $t = mb_strtolower(trim($text));

        if ($t === '') {
            return ['key' => 'umum', 'label' => 'Umum', 'color' => 'badge-teknologi'];
        }

        $bucket = [
            'desain'      => ['desain', 'design', 'ui', 'ux', 'grafis', 'kreatif', 'animasi', 'multimedia', 'foto', 'video', 'visual'],
            'pendidikan'  => ['pendidik', 'guru', 'pengajar', 'pelatih', 'training', 'kurikulum', 'pembelajaran', 'edukasi', 'dosen', 'mentor'],
            'bisnis'      => ['bisnis', 'manajemen', 'strategi', 'ekonomi', 'keuangan', 'finansial', 'brand', 'entrepreneur', 'usaha', 'pemasaran'],
            'teknologi'   => ['teknologi', 'program', 'coding', 'software', 'data', 'aplikasi', 'sistem', 'network', 'web', 'pemrograman'],
        ];

        $labels = [
            'desain'     => 'Desain & Kreatif',
            'pendidikan' => 'Pendidikan & Pelatihan',
            'bisnis'     => 'Bisnis & Manajemen',
            'teknologi'  => 'Teknologi & Data',
        ];
        $colors = [
            'desain'     => 'badge-desain',
            'pendidikan' => 'badge-pendidikan',
            'bisnis'     => 'badge-bisnis',
            'teknologi'  => 'badge-teknologi',
        ];

        foreach ($bucket as $key => $list) {
            foreach ($list as $kw) {
                if (str_contains($t, $kw)) {
                    return ['key' => $key, 'label' => $labels[$key], 'color' => $colors[$key]];
                }
            }
        }

        return ['key' => 'umum', 'label' => 'Umum', 'color' => 'badge-teknologi'];
    }

    /**
     * Pilih kategori talenta dari teks yang BENAR-BENAR terisi di DB
     * (bidang_pekerjaan / keahlian). Jika kosong -> bucket "Belum Diisi"
     * sehingga label "Programming" tidak lagi dicurangi secara default.
     *
     * @return array{key:string,label:string,color:string}
     */
    private function kategoriTalenta(string $text): array
    {
        $t = mb_strtolower(trim($text));

        if ($t === '') {
            return ['key' => 'umum', 'label' => 'Belum Diisi', 'color' => 'badge-data'];
        }

        $bucket = [
            'kreatif'   => ['foto', 'video', 'desain', 'design', 'logo', 'grafis', 'kreatif', 'animasi', 'dokumentasi', 'produk', 'kemasan', 'visual'],
            'digital'   => ['program', 'coding', 'software', 'sistem', 'situs', 'web', 'data', 'aplikasi', 'developer', 'it ', 'digital'],
            'pemasaran' => ['marketing', 'pemasaran', 'branding', 'sosial', 'media', 'konten', 'promosi', 'iklan', 'penjualan'],
        ];

        $labels = [
            'kreatif'   => 'Desain & Kreatif',
            'digital'   => 'Digital & Data',
            'pemasaran' => 'Pemasaran & Konten',
        ];
        $colors = [
            'kreatif'   => 'badge-design',
            'digital'   => 'badge-programming',
            'pemasaran' => 'badge-marketing',
        ];

        foreach ($bucket as $key => $list) {
            foreach ($list as $kw) {
                if (str_contains($t, $kw)) {
                    return ['key' => $key, 'label' => $labels[$key], 'color' => $colors[$key]];
                }
            }
        }

        return ['key' => 'umum', 'label' => 'Belum Diisi', 'color' => 'badge-data'];
    }

    /**
     * Pilih kategori client berdasarkan teks nyata. Mayoritas = UMKM.
     *
     * @return array{key:string,label:string,color:string}
     */
    private function kategoriClient(string $text): array
    {
        $t = mb_strtolower(trim($text));

        $bucket = [
            'korporasi'    => ['pt ', 'pt.', 'tbk', 'corporation', 'perusahaan', 'ltd'],
            'startup'      => ['startup', 'fintech', 'tech', 'aplikasi', 'platform'],
            'pemerintahan' => ['pemerintah', 'dinas', 'kecamatan', 'instansi', 'pemda', 'bumn', 'bumd', 'pemdes'],
        ];

        $labels = [
            'korporasi'    => 'Korporasi',
            'startup'      => 'Startup',
            'pemerintahan' => 'Pemerintahan',
            'umkm'         => 'UMKM',
        ];
        $colors = [
            'korporasi'    => 'badge-korporasi',
            'startup'      => 'badge-startup',
            'pemerintahan' => 'badge-pemerintahan',
            'umkm'         => 'badge-umkm',
        ];

        foreach ($bucket as $key => $list) {
            foreach ($list as $kw) {
                if (str_contains($t, $kw)) {
                    return ['key' => $key, 'label' => $labels[$key], 'color' => $colors[$key]];
                }
            }
        }

        // Tidak ada indikasi -> UMKM (mayoritas data Bakorwil memang UMKM).
        return ['key' => 'umkm', 'label' => 'UMKM', 'color' => 'badge-umkm'];
    }

    /**
     * Bangun daftar kategori yang benar-benar muncul di data, lengkap dengan
     * jumlah item per kategori (untuk opsi filter). 'umum' selalu ditaruh akhir.
     */
    private function countKategori(
        $items,
        string $keyField,
        string $labelField,
        string $colorField
    ): array {
        $list = [];

        foreach ($items as $item) {
            $key = $item[$keyField];
            if (! isset($list[$key])) {
                $list[$key] = [
                    'key'   => $key,
                    'label' => $item[$labelField],
                    'color' => $item[$colorField],
                    'count' => 0,
                ];
            }
            $list[$key]['count']++;
        }

        // Taruh bucket 'umum' paling belakang supaya filter tampak rapi.
        if (isset($list['umum'])) {
            $umum = $list['umum'];
            unset($list['umum']);
            $list['umum'] = $umum;
        }

        return array_values($list);
    }

    /**
     * Ubah data pengalaman menjadi tingkat (Senior / Mid / Junior)
     * agar cocok dengan levelColor yang digunakan renderer halaman talenta.
     */
    private function classifyLevel(?string $pengalaman, ?string $statusPekerjaan): string
    {
        $p = mb_strtolower((string) $pengalaman);

        // Tanpa data pengalaman -> jangan menebak "Mid"; pakai bucket netral.
        if (trim($p) === '') {
            return 'Umum';
        }

        if (preg_match('/tahun|senior|si|\\d{2,}/', $p)) {
            return 'Senior';
        }

        if (str_contains($p, 'junior') || str_contains($p, 'muda')) {
            return 'Junior';
        }

        if ($statusPekerjaan === 'magang' || str_contains($p, 'magang')) {
            return 'Junior';
        }

        return 'Mid';
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
