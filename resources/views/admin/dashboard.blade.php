@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@php
    $hariIndo  = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
    $bulanIndo = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    $totalClientAktif  = $stats->total_client_aktif  ?? 0;
    $totalMentorAktif  = $stats->total_mentor_aktif  ?? 0;
    $totalTalentaAktif = $stats->total_talenta_aktif ?? 0;
    $totalKegiatan     = $stats->total_kegiatan      ?? 0;
    $kegiatanUpcoming  = $stats->kegiatan_upcoming   ?? 0;
    $pendingChanges    = $stats->pending_changes     ?? 0;
    $pendingUsers      = $stats->pending_users       ?? 0;

    $mentorTotal = ($mentorAvailability['available'] ?? 0) + ($mentorAvailability['unavailable'] ?? 0);
    $mentorPct   = $mentorTotal > 0 ? round(($mentorAvailability['available'] / $mentorTotal) * 100) : 0;

    $jam   = (int) now()->format('G');
    $salam = $jam < 11 ? 'Selamat Pagi' : ($jam < 15 ? 'Selamat Siang' : ($jam < 19 ? 'Selamat Sore' : 'Selamat Malam'));
@endphp

@section('content')
<div class="space-y-6">

    <!-- Banner Sambutan -->
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-[#56b8c2] via-[#45a7b1] to-[#2e8791] p-6 md:p-7 text-white shadow-lg">
        <div class="absolute -right-8 -top-10 w-44 h-44 rounded-full bg-white/10 pointer-events-none" aria-hidden="true"></div>
        <div class="absolute right-28 -bottom-12 w-32 h-32 rounded-full bg-white/5 pointer-events-none" aria-hidden="true"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs font-medium uppercase tracking-widest text-white/70">{{ $hariIndo[now()->format('l')] }}, {{ now()->format('j') }} {{ $bulanIndo[(int) now()->format('n')] }} {{ now()->format('Y') }}</p>
                <h1 class="mt-1 text-2xl font-bold">{{ $salam }}, {{ auth()->user()->name ?? 'Admin' }}</h1>
                <p class="mt-1 text-sm text-white/80">Berikut ringkasan data platform EJSC Bakorwil hari ini.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur px-3 py-1.5 rounded-full text-xs font-semibold">{{ $kegiatanUpcoming }} kegiatan mendatang</span>
                <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur px-3 py-1.5 rounded-full text-xs font-semibold">{{ number_format($totalClientAktif + $totalMentorAktif + $totalTalentaAktif) }} data aktif</span>
            </div>
        </div>
    </div>

    <!-- Peringatan yang Perlu Tindakan -->
    @if($pendingUsers > 0 || $pendingChanges > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($pendingUsers > 0)
                <div class="flex items-center justify-between gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">&#128100;</span>
                        <p class="text-sm text-amber-800"><strong>{{ $pendingUsers }} pengguna</strong> menunggu verifikasi.</p>
                    </div>
                    <a href="{{ route('admin.activity-logs') }}" class="text-xs font-semibold text-amber-700 hover:text-amber-900 hover:underline whitespace-nowrap">Periksa &rarr;</a>
                </div>
            @endif
            @if($pendingChanges > 0)
                <div class="flex items-center justify-between gap-3 bg-sky-50 border border-sky-200 rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">&#9999;&#65039;</span>
                        <p class="text-sm text-sky-800"><strong>{{ $pendingChanges }} perubahan profil</strong> menunggu persetujuan.</p>
                    </div>
                    <a href="{{ route('admin.activity-logs') }}" class="text-xs font-semibold text-sky-700 hover:text-sky-900 hover:underline whitespace-nowrap">Periksa &rarr;</a>
                </div>
            @endif
        </div>
    @endif

    <!-- Kartu Statistik Utama (menuju halaman kelola) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        {{-- Client --}}
        <a href="{{ route('admin.clients.index') }}" class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-lg flex items-center justify-center text-2xl" title="Client">&#127970;</div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-sky-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            <p class="mt-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola Client</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalClientAktif) }}</h3>
            <p class="text-xs text-gray-400 mt-0.5">aktif &middot; {{ number_format($totals['clients']) }} total terdaftar</p>
        </a>

        {{-- Mentor --}}
        <a href="{{ route('admin.mentors.index') }}" class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-2xl" title="Mentor">&#127891;</div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            <p class="mt-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola Mentor</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalMentorAktif) }}</h3>
            <p class="text-xs text-gray-400 mt-0.5">aktif &middot; {{ number_format($totals['mentors']) }} total terdaftar</p>
        </a>

        {{-- Talenta --}}
        <a href="{{ route('admin.talents.index') }}" class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-2xl" title="Talenta">&#128161;</div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-purple-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            <p class="mt-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola Talenta</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalTalentaAktif) }}</h3>
            <p class="text-xs text-gray-400 mt-0.5">aktif &middot; {{ number_format($totals['talents']) }} total terdaftar</p>
        </a>

        {{-- Kegiatan --}}
        <a href="{{ route('admin.kegiatans.index') }}" class="group bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center text-2xl" title="Kegiatan">&#128197;</div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-amber-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            <p class="mt-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola Kegiatan</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($kegiatanUpcoming) }}</h3>
            <p class="text-xs text-gray-400 mt-0.5">mendatang &middot; {{ number_format($totalKegiatan) }} total kegiatan</p>
        </a>
    </div>

    <!-- Baris Grafik: Pertumbuhan & Client per Produk -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Pertumbuhan Data</h3>
                    <p class="text-xs text-gray-400">Data baru per bulan &middot; 6 bulan terakhir</p>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider bg-gray-100 text-gray-500 px-2 py-1 rounded-full">Grafik</span>
            </div>
            <div class="h-64"><canvas id="chart-growth"></canvas></div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="mb-4">
                <h3 class="text-base font-bold text-gray-800">Client per Produk</h3>
                <p class="text-xs text-gray-400">Distribusi client aktif berdasarkan nama produk</p>
            </div>
            @if($clientsByProduct->count())
                <div class="h-64"><canvas id="chart-produk"></canvas></div>
            @else
                <div class="h-64 flex flex-col items-center justify-center text-center text-gray-400">
                    <span class="text-3xl mb-2">&#127970;</span>
                    <p class="text-sm">Belum ada data produk client.</p>
                    <a href="{{ route('admin.clients.create') }}" class="mt-2 text-xs font-semibold text-[#56b8c2] hover:underline">+ Tambah client pertama</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Baris: Status Pekerjaan Talenta, Ketersediaan Mentor, Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="mb-4">
                <h3 class="text-base font-bold text-gray-800">Status Pekerjaan Talenta</h3>
                <p class="text-xs text-gray-400">Talenta aktif per status pekerjaan</p>
            </div>
            @if($talentsByStatus->count())
                <div class="h-56"><canvas id="chart-status"></canvas></div>
            @else
                <div class="h-56 flex flex-col items-center justify-center text-center text-gray-400">
                    <span class="text-3xl mb-2">&#128161;</span>
                    <p class="text-sm">Belum ada data status pekerjaan.</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="mb-4">
                <h3 class="text-base font-bold text-gray-800">Ketersediaan Mentor</h3>
                <p class="text-xs text-gray-400">Mentor aktif yang siap dibooking</p>
            </div>
            <div class="flex items-end justify-between mb-2">
                <span class="text-3xl font-bold text-emerald-600">{{ $mentorPct }}%</span>
                <span class="text-xs text-gray-400">{{ $mentorAvailability['available'] ?? 0 }} dari {{ $mentorTotal }} mentor</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden" role="progressbar" aria-valuenow="{{ $mentorPct }}" aria-valuemin="0" aria-valuemax="100">
                <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full transition-all" style="width: {{ $mentorPct }}%"></div>
            </div>
            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2 text-gray-600"><span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>Available</span>
                    <span class="font-bold text-emerald-600">{{ $mentorAvailability['available'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2 text-gray-600"><span class="w-2.5 h-2.5 bg-rose-400 rounded-full"></span>Full / Unavailable</span>
                    <span class="font-bold text-rose-500">{{ $mentorAvailability['unavailable'] ?? 0 }}</span>
                </div>
            </div>
            <a href="{{ route('admin.mentors.index') }}?is_available=0" class="mt-4 block text-center text-xs font-semibold text-[#56b8c2] hover:underline">Kelola ketersediaan mentor &rarr;</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="mb-4">
                <h3 class="text-base font-bold text-gray-800">Aksi Cepat</h3>
                <p class="text-xs text-gray-400">Tambah data baru dengan satu klik</p>
            </div>
            <div class="grid grid-cols-1 gap-2">
                <a href="{{ route('admin.clients.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 text-sm font-medium transition"><span>&#127970;</span> Tambah Client</a>
                <a href="{{ route('admin.mentors.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-medium transition"><span>&#127891;</span> Tambah Mentor</a>
                <a href="{{ route('admin.talents.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium transition"><span>&#128161;</span> Tambah Talenta</a>
                <a href="{{ route('admin.kegiatans.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-medium transition"><span>&#128197;</span> Tambah Kegiatan</a>
            </div>
        </div>
    </div>

    <!-- Baris Bawah: Kegiatan Mendatang & Aktivitas Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Kegiatan Mendatang</h3>
                    <p class="text-xs text-gray-400">5 kegiatan terdekat yang akan berlangsung</p>
                </div>
                <a href="{{ route('admin.kegiatans.index') }}" class="text-xs text-[#56b8c2] hover:underline font-medium">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($upcomingKegiatans as $kegiatan)
                    <a href="{{ route('admin.kegiatans.show', $kegiatan->id_kegiatan) }}" class="py-3 flex items-center gap-4 group hover:bg-gray-50 -mx-2 px-2 rounded-lg transition">
                        <div class="w-12 h-14 flex-shrink-0 rounded-lg bg-gradient-to-b from-[#56b8c2] to-[#2e8791] text-white flex flex-col items-center justify-center leading-tight">
                            <span class="text-lg font-bold">{{ $kegiatan->tanggal_kegiatan?->format('d') ?? '-' }}</span>
                            <span class="text-[10px] uppercase">{{ $kegiatan->tanggal_kegiatan?->format('M') ?? '' }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-[#56b8c2] transition">{{ $kegiatan->judul_kegiatan }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $kegiatan->lokasi ?? 'Lokasi belum ditentukan' }} &middot; {{ $kegiatan->organizer?->name ?? '-' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-bold text-gray-700">{{ $kegiatan->registered_count ?? 0 }}<span class="text-gray-400 font-medium">/{{ $kegiatan->max_participants ?? '&infin;' }}</span></p>
                            <p class="text-[10px] uppercase tracking-wide text-gray-400">peserta</p>
                        </div>
                    </a>
                @empty
                    <div class="py-8 flex flex-col items-center text-center text-gray-400">
                        <span class="text-3xl mb-2">&#128197;</span>
                        <p class="text-sm">Belum ada kegiatan mendatang.</p>
                        <a href="{{ route('admin.kegiatans.create') }}" class="mt-2 text-xs font-semibold text-[#56b8c2] hover:underline">+ Buat kegiatan baru</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Terbaru (Audit Log) -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-800">Aktivitas Terbaru</h3>
                <a href="{{ route('admin.activity-logs') }}" class="text-xs text-[#56b8c2] hover:underline font-medium">Audit Logs</a>
            </div>
            <ol class="relative border-l-2 border-gray-100 ml-2 space-y-4">
                @forelse($recentActivities->take(6) as $log)
                    <li class="pl-4 relative">
                        <span class="absolute -left-[25px] top-1 w-3 h-3 rounded-full ring-4 ring-white
                            {{ $log->action === 'create' ? 'bg-emerald-400' : '' }}
                            {{ $log->action === 'update' ? 'bg-amber-400' : '' }}
                            {{ $log->action === 'delete' ? 'bg-rose-400' : '' }}
                            {{ !in_array($log->action, ['create', 'update', 'delete']) ? 'bg-gray-300' : '' }}"></span>
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold uppercase text-xs px-1.5 py-0.5 rounded
                                {{ $log->action === 'create' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $log->action === 'update' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $log->action === 'delete' ? 'bg-rose-100 text-rose-700' : '' }}">{{ $log->action }}</span>
                            <span class="font-medium">{{ $log->table_name }}</span>
                            @if($log->record_id)<span class="text-gray-400 text-xs">#{{ $log->record_id }}</span>@endif
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $log->user?->name ?? 'Sistem' }} &middot; {{ $log->created_at?->diffForHumans() ?? '-' }}</p>
                    </li>
                @empty
                    <li class="pl-4 py-4 text-sm text-gray-400">Belum ada aktivitas tercatat.</li>
                @endforelse
            </ol>
        </div>
    </div>

    <!-- Client Terbaru -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-bold text-gray-800">Client Terbaru</h3>
                <p class="text-xs text-gray-400">Client (UMKM) yang paling baru ditambahkan</p>
            </div>
            <a href="{{ route('admin.clients.index') }}" class="text-xs text-[#56b8c2] hover:underline font-medium">Kelola Client</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-3">
            @forelse($recentClients as $client)
                <a href="{{ route('admin.clients.show', $client->id_client) }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-[#56b8c2]/50 hover:bg-[#f0f9fa]/60 transition">
                    <div class="w-10 h-10 flex-shrink-0 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-sm overflow-hidden">
                        @if($client->foto_logo_src)
                            <img src="{{ $client->foto_logo_src }}" alt="{{ $client->nama_ukm }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(mb_substr($client->nama_ukm ?? 'C', 0, 1)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $client->nama_ukm }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $client->nama_produk ?? $client->domisili ?? '-' }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-full py-4 text-center text-sm text-gray-400">Belum ada client terdaftar.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.Chart === 'undefined') return;

        var PRIMARY = '#56b8c2';
        var PALETTE = ['#56b8c2', '#f59e0b', '#10b981', '#6366f1', '#ef4444', '#8b5cf6', '#0ea5e9', '#84cc16'];
        var TOOLTIP = { backgroundColor: '#1e293b', padding: 10, cornerRadius: 8, titleFont: { weight: 'bold' } };

        /* Line Chart: Pertumbuhan Data 6 Bulan Terakhir */
        var growthEl = document.getElementById('chart-growth');
        if (growthEl) {
            new Chart(growthEl, {
                type: 'line',
                data: {
                    labels: @json($growth['labels']),
                    datasets: [
                        { label: 'Client',  data: @json($growth['clients']), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.08)', tension: .35, fill: true, pointRadius: 3 },
                        { label: 'Mentor',  data: @json($growth['mentors']), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,.08)', tension: .35, fill: true, pointRadius: 3 },
                        { label: 'Talenta', data: @json($growth['talents']), borderColor: PRIMARY, backgroundColor: 'rgba(86,184,194,.12)', tension: .35, fill: true, pointRadius: 3 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }, tooltip: TOOLTIP },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        /* Doughnut: Client Aktif per Produk */
        var produkEl = document.getElementById('chart-produk');
        if (produkEl && @json($clientsByProduct->count()) > 0) {
            new Chart(produkEl, {
                type: 'doughnut',
                data: {
                    labels: @json($clientsByProduct->pluck('nama_produk')),
                    datasets: [{ data: @json($clientsByProduct->pluck('total')), backgroundColor: PALETTE, borderWidth: 2, borderColor: '#ffffff' }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '62%',
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 12 } }, tooltip: TOOLTIP }
                }
            });
        }

        /* Bar: Talenta Aktif per Status Pekerjaan */
        var statusEl = document.getElementById('chart-status');
        if (statusEl && @json($talentsByStatus->count()) > 0) {
            new Chart(statusEl, {
                type: 'bar',
                data: {
                    labels: @json(collect($talentsByStatus)->pluck('status_pekerjaan')->map(fn ($s) => ucwords(str_replace('_', ' ', $s)))),
                    datasets: [{ label: 'Talenta', data: @json($talentsByStatus->pluck('total')), backgroundColor: 'rgba(86,184,194,.75)', hoverBackgroundColor: PRIMARY, borderRadius: 6, maxBarThickness: 42 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: TOOLTIP },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endsection
