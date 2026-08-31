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
     * =========================================================
     * HOME / DASHBOARD PUBLIC
     * =========================================================
     */
    public function index()
    {
        $stats = [
            'clients'   => Client::active()->count(),
            'mentors'   => Mentor::active()->count(),
            'talents'   => Talent::active()->count(),
            'kegiatans' => Kegiatan::public()->upcoming()->count(),
        ];

        $upcomingKegiatans = Kegiatan::public()
            ->upcoming()
            ->latest('tanggal_kegiatan')
            ->limit(3)
            ->get();

        return view('home', compact(
            'stats',
            'upcomingKegiatans'
        ));
    }


    /**
     * =========================================================
     * TENTANG KAMI
     * =========================================================
     */
    public function tentangKami()
    {
        $statistik = [
            'mentor'   => Mentor::active()->count(),
            'talenta'  => Talent::active()->count(),
            'client'   => Client::active()->count(),
            'kegiatan' => Kegiatan::public()->upcoming()->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Pertumbuhan platform
        |--------------------------------------------------------------------------
        | 8 bulan terakhir
        */

        $namaBulan = [
            1  => 'Jan',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Apr',
            5  => 'Mei',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Agu',
            9  => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $bulan = collect(range(7, 0))->map(function ($i) use ($namaBulan) {
            $tanggal = now()->copy()->subMonths($i);

            return [
                'key'   => $tanggal->format('Y-m'),
                'label' => $namaBulan[(int) $tanggal->format('n')],
            ];
        });

        $bulanKeys = $bulan->pluck('key')->all();

        $pertumbuhan = [
            'labels'  => $bulan->pluck('label')->all(),
            'mentor'  => $this->kumulatifPerBulan('mentor', $bulanKeys),
            'talenta' => $this->kumulatifPerBulan('talenta', $bulanKeys),
            'client'  => $this->kumulatifPerBulan('client', $bulanKeys),
        ];

        /*
        |--------------------------------------------------------------------------
        | Distribusi keahlian
        |--------------------------------------------------------------------------
        */

        $distribusiTalenta = $this->topKeahlian(
            Talent::query()
        );

        $distribusiMentor = $this->topKeahlian(
            Mentor::query()
        );

        return view('tentang-kami', compact(
            'statistik',
            'pertumbuhan',
            'distribusiTalenta',
            'distribusiMentor'
        ));
    }


    /**
     * =========================================================
     * KUMULATIF DATA PER BULAN
     * =========================================================
     */
    private function kumulatifPerBulan(
        string $table,
        array $bulanKeys
    ): array {
        $perBulan = DB::table($table)
            ->whereNotNull('created_at')
            ->selectRaw(
                "to_char(created_at, 'YYYY-MM') as bulan, count(*) as total"
            )
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $jumlah = 0;

        return collect($bulanKeys)
            ->map(function ($key) use ($perBulan, &$jumlah) {
                $jumlah += (int) ($perBulan[$key] ?? 0);

                return $jumlah;
            })
            ->all();
    }


    /**
     * =========================================================
     * TOP KEAHLIAN
     * =========================================================
     */
    private function topKeahlian(
        $query,
        int $limit = 5
    ): array {
        $jumlah = $query
            ->toBase()
            ->whereNotNull('keahlian')
            ->where('keahlian', '!=', '')
            ->pluck('keahlian')
            ->flatMap(function ($value) {
                return preg_split(
                    '/[,;]+/u',
                    $value
                );
            })
            ->map(function ($value) {
                return trim($value);
            })
            ->filter(function ($value) {
                return $value !== '';
            })
            ->countBy()
            ->sortDesc()
            ->take($limit);

        return [
            'labels' => $jumlah->keys()->all(),
            'data'   => $jumlah->values()->all(),
        ];
    }


    /**
     * =========================================================
     * DAFTAR CLIENT
     * =========================================================
     */
    public function clients(Request $request)
    {
        $query = Client::publicData()
            ->active();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_ukm',
                    'ILIKE',
                    "%{$search}%"
                )->orWhere(
                    'nama_produk',
                    'ILIKE',
                    "%{$search}%"
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter produk
        |--------------------------------------------------------------------------
        */

        if ($request->filled('nama_produk')) {
            $query->where(
                'nama_produk',
                'ILIKE',
                "%{$request->nama_produk}%"
            );
        }

        $clients = $query
            ->latest()
            ->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | DAFTAR CLIENT ADA DI:
        | resources/views/client.blade.php
        |--------------------------------------------------------------------------
        */

        $kategoriClient = $this->kategoriClient();

        return view(
            'client',
            compact(
                'clients',
                'kategoriClient'
            )
        );
    }


    /**
     * =========================================================
     * KATEGORI CLIENT (untuk filter halaman publik)
     * =========================================================
     */
    private function kategoriClient(): array
    {
        return Client::active()
            ->get([
                'nama_ukm',
                'nama_produk',
                'deskripsi_usaha',
                'website',
            ])
            ->groupBy(fn ($client) => Client::kategoriKey($client))
            ->map(function ($group, $key) {
                return [
                    'key'   => $key,
                    'label' => $this->clientKategoriLabel($key),
                    'count' => $group->count(),
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->all();
    }


    private function clientKategoriLabel(string $key): string
    {
        return match ($key) {
            'korporasi'    => 'Korporasi',
            'startup'      => 'Startup',
            'pemerintahan' => 'Pemerintahan',
            default        => 'UMKM',
        };
    }


    /**
     * =========================================================
     * DETAIL CLIENT
     * =========================================================
     */
    public function clientShow(Client $client)
    {
        /*
        |--------------------------------------------------------------------------
        | Hanya client aktif
        |--------------------------------------------------------------------------
        */

        if ($client->status !== 'aktif') {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data publik
        |--------------------------------------------------------------------------
        */

        $client = Client::publicData()
            ->where(
                'id_client',
                $client->id_client
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | DETAIL CLIENT ADA DI:
        | resources/views/public/client-show.blade.php
        |--------------------------------------------------------------------------
        */

        return view(
            'public.client-show',
            compact('client')
        );
    }


    /**
     * =========================================================
     * DAFTAR MENTOR
     * =========================================================
     */
    public function mentors(Request $request)
    {
        $query = Mentor::publicData()
            ->active();

        /*
        |--------------------------------------------------------------------------
        | Search mentor
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama',
                    'ILIKE',
                    "%{$search}%"
                )->orWhere(
                    'keahlian',
                    'ILIKE',
                    "%{$search}%"
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter keahlian
        |--------------------------------------------------------------------------
        */

        if ($request->filled('keahlian')) {
            $query->where(
                'keahlian',
                'ILIKE',
                "%{$request->keahlian}%"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter availability
        |--------------------------------------------------------------------------
        */

        if ($request->filled('is_available')) {
            $query->where(
                'is_available',
                $request->is_available === '1'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $mentors = $query
            ->latest()
            ->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | DAFTAR MENTOR ADA DI:
        | resources/views/mentor.blade.php
        |
        | BUKAN:
        | resources/views/public/mentors.blade.php
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Kategori bidang untuk dropdown filter halaman publik
        |--------------------------------------------------------------------------
        */

        $kategoriMentor = $this->kategoriMentor();

        return view(
            'mentor',
            compact(
                'mentors',
                'kategoriMentor'
            )
        );
    }


    /**
     * =========================================================
     * KATEGORI MENTOR (untuk dropdown & label JS halaman publik)
     * =========================================================
     */
    private function kategoriMentor(): array
    {
        return Mentor::active()
            ->get(['keahlian'])
            ->groupBy(fn ($mentor) => Mentor::bidangKey($mentor))
            ->map(function ($group, $key) {
                return [
                    'key'   => $key,
                    'label' => $this->mentorBidangLabel($key),
                    'count' => $group->count(),
                    'color' => 'badge-' . $key,
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->all();
    }


    private function mentorBidangLabel(string $key): string
    {
        return match ($key) {
            'teknologi' => 'Teknologi',
            'bisnis'    => 'Bisnis',
            'desain'    => 'Desain',
            default     => 'Pendidikan',
        };
    }


    /**
     * =========================================================
     * DETAIL MENTOR
     * =========================================================
     */
    public function mentorShow(Mentor $mentor)
    {
        /*
        |--------------------------------------------------------------------------
        | Hanya mentor aktif
        |--------------------------------------------------------------------------
        */

        if ($mentor->status !== 'aktif') {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data publik
        |--------------------------------------------------------------------------
        */

        $mentor = Mentor::publicData()
            ->where(
                'id_mentor',
                $mentor->id_mentor
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | DETAIL MENTOR ADA DI:
        | resources/views/public/mentor-show.blade.php
        |--------------------------------------------------------------------------
        */

        return view(
            'public.mentor-show',
            compact('mentor')
        );
    }


    /**
     * =========================================================
     * DAFTAR TALENTA
     * =========================================================
     */
    public function talents(Request $request)
    {
        $query = Talent::publicData()
            ->active();

        /*
        |--------------------------------------------------------------------------
        | Search talent
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama',
                    'ILIKE',
                    "%{$search}%"
                )->orWhere(
                    'keahlian',
                    'ILIKE',
                    "%{$search}%"
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter keahlian
        |--------------------------------------------------------------------------
        */

        if ($request->filled('keahlian')) {
            $query->where(
                'keahlian',
                'ILIKE',
                "%{$request->keahlian}%"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter status pekerjaan
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status_pekerjaan')) {
            $query->where(
                'status_pekerjaan',
                $request->status_pekerjaan
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $talents = $query
            ->latest()
            ->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | DAFTAR TALENTA ADA DI:
        | resources/views/talenta.blade.php
        |--------------------------------------------------------------------------
        */

        $kategoriTalenta = $this->kategoriTalenta();

        return view(
            'talenta',
            compact(
                'talents',
                'kategoriTalenta'
            )
        );
    }


    /**
     * =========================================================
     * KATEGORI TALENTA (untuk dropdown halaman publik)
     * =========================================================
     */
    private function kategoriTalenta(): array
    {
        return Talent::active()
            ->get(['keahlian'])
            ->groupBy(fn ($talent) => Talent::skillKey($talent))
            ->map(function ($group, $key) {
                return [
                    'key'   => $key,
                    'label' => $this->talentaSkillLabel($key),
                    'count' => $group->count(),
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->all();
    }


    private function talentaSkillLabel(string $key): string
    {
        return match ($key) {
            'programming' => 'Programming',
            'design'      => 'Design',
            'marketing'   => 'Marketing',
            default       => 'Data Analysis',
        };
    }


    /**
     * =========================================================
     * DETAIL TALENTA
     * =========================================================
     */
    public function talentShow(Talent $talent)
    {
        /*
        |--------------------------------------------------------------------------
        | Hanya talent aktif
        |--------------------------------------------------------------------------
        */

        if ($talent->status !== 'aktif') {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data publik + mentor
        |--------------------------------------------------------------------------
        */

        $talent = Talent::publicData()
            ->where(
                'id_talenta',
                $talent->id_talenta
            )
            ->with(
                'mentor:id_mentor,nama,keahlian'
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | DETAIL TALENTA ADA DI:
        | resources/views/public/talent-show.blade.php
        |--------------------------------------------------------------------------
        */

        return view(
            'public.talent-show',
            compact('talent')
        );
    }


    /**
     * =========================================================
     * DAFTAR KEGIATAN
     * =========================================================
     */
    public function kegiatans(Request $request)
    {
        $this->authorize(
            'viewAny',
            Kegiatan::class
        );

        $query = Kegiatan::public()
            ->with('organizer');

        /*
        |--------------------------------------------------------------------------
        | Search kegiatan
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'judul_kegiatan',
                'ILIKE',
                "%{$search}%"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Default: kegiatan yang akan datang
        |--------------------------------------------------------------------------
        */

        if (!$request->filled('show_past')) {
            $query->upcoming();
        }

        $kegiatans = $query
            ->latest('tanggal_kegiatan')
            ->paginate(12);

        /*
        |--------------------------------------------------------------------------
        | DAFTAR KEGIATAN ADA DI:
        | resources/views/kegiatan.blade.php
        |--------------------------------------------------------------------------
        */

        return view(
            'kegiatan',
            compact('kegiatans')
        );
    }


    /**
     * =========================================================
     * DETAIL KEGIATAN
     * =========================================================
     */
    public function kegiatanShow(Kegiatan $kegiatan)
    {
        $this->authorize(
            'view',
            $kegiatan
        );

        $kegiatan->load('organizer');

        $isRegistered = false;
        $userParticipation = null;

        /*
        |--------------------------------------------------------------------------
        | Cek status pendaftaran user
        |--------------------------------------------------------------------------
        */

        if (auth()->check()) {
            $userParticipation = KegiatanParticipant::where(
                'id_kegiatan',
                $kegiatan->id_kegiatan
            )
                ->where(
                    'id_user',
                    auth()->id()
                )
                ->first();

            $isRegistered = $userParticipation !== null;
        }

        /*
        |--------------------------------------------------------------------------
        | Slot kegiatan
        |--------------------------------------------------------------------------
        */

        $availableSlots = $kegiatan->hasAvailableSlots();

        $participantCount = $kegiatan->participants()
            ->wherePivot(
                'status',
                '!=',
                'cancelled'
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | DETAIL KEGIATAN ADA DI:
        | resources/views/public/kegiatan-show.blade.php
        |--------------------------------------------------------------------------
        */

        return view(
            'public.kegiatan-show',
            compact(
                'kegiatan',
                'isRegistered',
                'userParticipation',
                'availableSlots',
                'participantCount'
            )
        );
    }


    /**
     * =========================================================
     * DAFTAR KEGIATAN / REGISTER
     * =========================================================
     */
    public function kegiatanRegister(
        Request $request,
        Kegiatan $kegiatan
    ) {
        $this->authorize(
            'register',
            $kegiatan
        );

        /*
        |--------------------------------------------------------------------------
        | Cek slot
        |--------------------------------------------------------------------------
        */

        if (!$kegiatan->hasAvailableSlots()) {
            return back()->with(
                'error',
                'Maaf, kegiatan ini sudah penuh.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek pendaftaran sebelumnya
        |--------------------------------------------------------------------------
        */

        $existing = KegiatanParticipant::where(
            'id_kegiatan',
            $kegiatan->id_kegiatan
        )
            ->where(
                'id_user',
                auth()->id()
            )
            ->first();

        if ($existing) {
            return back()->with(
                'error',
                'Anda sudah terdaftar untuk kegiatan ini.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan peserta
        |--------------------------------------------------------------------------
        */

        KegiatanParticipant::create([
            'id_kegiatan'   => $kegiatan->id_kegiatan,
            'id_user'       => auth()->id(),
            'status'        => 'registered',
            'registered_at' => now(),
            'notes'         => $validated['notes'] ?? null,
        ]);

        return back()->with(
            'success',
            'Pendaftaran berhasil! Silakan tunggu konfirmasi dari admin.'
        );
    }


    /**
     * =========================================================
     * BATAL PENDAFTARAN KEGIATAN
     * =========================================================
     */
    public function kegiatanCancel(
        Kegiatan $kegiatan
    ) {
        $participation = KegiatanParticipant::where(
            'id_kegiatan',
            $kegiatan->id_kegiatan
        )
            ->where(
                'id_user',
                auth()->id()
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Tidak bisa membatalkan jika sudah hadir
        |--------------------------------------------------------------------------
        */

        if ($participation->status === 'attended') {
            return back()->with(
                'error',
                'Tidak dapat membatalkan pendaftaran yang sudah hadir.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Batalkan
        |--------------------------------------------------------------------------
        */

        $participation->cancel();

        return back()->with(
            'success',
            'Pendaftaran berhasil dibatalkan.'
        );
    }
}