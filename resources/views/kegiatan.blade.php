@extends('layouts.app')

@section('title', 'Kegiatan - EJSC Bakorwil')

@php
    /*
    | Locale aplikasi "en", jadi tanggal diformat manual agar tetap
    | berbahasa Indonesia (pola sama dengan DashboardController).
    */
    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $formatTanggal = function ($tanggal) use ($bulanIndo) {
        return $tanggal
            ? $tanggal->day . ' ' . $bulanIndo[(int) $tanggal->format('n')] . ' ' . $tanggal->year
            : '-';
    };

    $statusMap = [
        'akan_datang' => ['label' => 'Akan Datang', 'class' => 'status-akan-datang'],
        'berlangsung' => ['label' => 'Berlangsung', 'class' => 'status-berlangsung'],
        'selesai'     => ['label' => 'Selesai', 'class' => 'status-selesai'],
        'dibatalkan'  => ['label' => 'Dibatalkan', 'class' => 'status-dibatalkan'],
    ];
@endphp

@section('content')

<div class="kegiatan-page">

    <!-- HERO -->
    <section class="kegiatan-hero py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 bg-white/70 px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                Agenda EJSC
            </span>
            <h1 class="hero-title text-4xl font-bold mb-4">
                Kegiatan <span>EJSC Bakorwil</span>
            </h1>
            <p class="hero-description text-lg max-w-2xl mx-auto">
                Ikuti berbagai pelatihan, workshop, dan acara komunitas yang kami selenggarakan
                untuk mentor, talenta, dan client.
            </p>
        </div>
    </section>

    <!-- LIST KEGIATAN -->
    <section class="py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Search & Filter -->
            <div class="mb-4 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                <div class="relative md:w-80">
                    <svg class="w-5 h-5 text-[#7da0ad] absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search-input" type="text" placeholder="Cari kegiatan..."
                        class="kegiatan-search w-full pl-10 pr-4 py-2.5 border border-[#d5ebee] rounded-xl bg-white placeholder-[#8ba4af] focus:outline-none">
                </div>

                <select id="filter-select" class="kegiatan-filter px-4 py-2.5 border border-[#d5ebee] rounded-xl bg-white focus:outline-none">
                    <option value="semua">Semua Status</option>
                    <option value="akan_datang">Akan Datang</option>
                    <option value="berlangsung">Berlangsung</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <!-- Toggle kegiatan yang sudah lewat -->
            <div class="mb-8 text-sm">
                @if(request('show_past'))
                    <a href="{{ url()->current() }}" class="text-[#14b8c4] hover:text-[#0e9aa5] font-medium">
                        &larr; Tampilkan hanya kegiatan mendatang
                    </a>
                @else
                    <a href="{{ url()->current() }}?show_past=1" class="text-[#7da0ad] hover:text-[#14b8c4] font-medium">
                        Tampilkan juga kegiatan yang sudah lewat &rarr;
                    </a>
                @endif
            </div>

            <div id="kegiatan-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kegiatans as $kegiatan)
                    @php
                        $st = $statusMap[$kegiatan->status]
                            ?? ['label' => ucfirst((string) $kegiatan->status), 'class' => 'status-akan-datang'];
                    @endphp

                    <a href="{{ route('public.kegiatans.show', $kegiatan->id_kegiatan) }}"
                       class="kegiatan-card block"
                       data-status="{{ $kegiatan->status }}"
                       data-keyword="{{ strtolower(($kegiatan->judul_kegiatan ?? '') . ' ' . ($kegiatan->deskripsi ?? '')) }}">
                        <div class="kegiatan-cover">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="kegiatan-status {{ $st['class'] }}">{{ $st['label'] }}</span>
                        </div>
                        <div class="kegiatan-body">
                            <div class="kegiatan-tanggal">{{ $formatTanggal($kegiatan->tanggal_kegiatan) }}</div>
                            <h3>{{ $kegiatan->judul_kegiatan }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($kegiatan->deskripsi ?? 'Informasi kegiatan akan segera tersedia.', 110) }}</p>
                            <div class="kegiatan-meta">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $kegiatan->lokasi ?? 'EJSC Bakorwil' }}</span>
                                @if(!is_null($kegiatan->max_participants))
                                    <span class="ml-auto whitespace-nowrap">Kuota: {{ $kegiatan->max_participants }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div id="empty-db" class="col-span-full text-center py-16 text-[#7da0ad]">
                        Belum ada kegiatan yang dapat ditampilkan.
                    </div>
                @endforelse
            </div>

            <div id="empty-state" class="hidden text-center py-16 text-[#7da0ad]">
                Tidak ada kegiatan yang cocok dengan pencarian.
            </div>

            @if($kegiatans->hasPages())
                <div class="mt-10">
                    {{ $kegiatans->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </section>

</div>

<script>
    // Filter client-side di atas kartu hasil render Blade (data dari database)
    const searchInput = document.getElementById('search-input');
    const filterSelect = document.getElementById('filter-select');
    const emptyState = document.getElementById('empty-state');
    const emptyDb = document.getElementById('empty-db');
    const cards = document.querySelectorAll('#kegiatan-list .kegiatan-card');

    function renderKegiatan() {
        const keyword = searchInput.value.trim().toLowerCase();
        const status = filterSelect.value;
        let visible = 0;

        cards.forEach((card) => {
            const matchKeyword = keyword === '' || (card.dataset.keyword || '').includes(keyword);
            const matchStatus = status === 'semua' || card.dataset.status === status;
            const show = matchKeyword && matchStatus;

            card.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        emptyState.classList.toggle('hidden', visible > 0);

        if (emptyDb) {
            // Saat user memfilter, sembunyikan pesan "belum ada kegiatan"
            emptyDb.classList.toggle('hidden', visible > 0 || keyword !== '' || status !== 'semua');
        }
    }

    searchInput.addEventListener('input', renderKegiatan);
    filterSelect.addEventListener('change', renderKegiatan);
    renderKegiatan();
</script>

@endsection
