@extends('layouts.app')

@section('title', 'Tentang Kami - EJSC Bakorwil')

@section('content')
<style>
/* TULISAN JELAJAHI PROGRAM JADI PUTIH */
.tentang-hero .hero-button {
    color: #ffffff !important;
}

.tentang-hero .hero-button span {
    color: #ffffff !important;
}
</style>

<div
    id="about"
    class="tentang-page"
    style="--page-image: url('{{ Vite::asset('resources/images/ejsc.png') }}');"
>

    <!-- HERO -->
    <section class="tentang-hero" style="--hero-image: url('{{ Vite::asset('resources/images/ejsc.png') }}');">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="hero-shell">
                <div class="hero-copy">
                    <span class="hero-kicker">
                        ✦ EJSC BAKORWIL
                    </span>

                    <h1 class="hero-title">
                        Menghubungkan <span class="hero-highlight">Mentor, Talenta &amp; Klien</span> di Jawa Timur.
                    </h1>

                    <p class="hero-description">
                        Platform resmi EJSC Bakorwil untuk mengakselerasi pengembangan talenta, mempertemukan mentor berpengalaman, dan membuka akses bagi klien yang membutuhkan sumber daya manusia berkualitas.
                    </p>

                    <div class="hero-actions">
                        <a
                         href="https://docs.google.com/forms/d/e/1FAIpQLSdLP-uZnwGnCpNDx-yStzu-k0ohhaZWwNl3lXkEm0hb6Iqvvg/viewform?pli=1"
                         class="hero-button"
                         target="_blank"
                          rel="noopener noreferrer"
                         >
                               Daftar Hadir Buku Tamu <span aria-hidden="true">→</span>
                    </a>
                    </div>

                </div>

               <div class="hero-visual" aria-label="Gedung EJSC Bakorwil">

    <div class="hero-visual-card">

        <!-- FOTO GEDUNG EJSC -->
        <div class="hero-building-image">
            <img
                src="{{ Vite::asset('resources/images/ejsc.png') }}"
                alt="Gedung EJSC "
            >
        </div>


        </div>

    </div>

</div>
    </section>

    <!-- STATISTIK -->
    <section class="py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div class="stat-mini">
                    <div class="value">{{ $statistik['mentor'] }}</div>
                    <div class="label">Mentor Aktif</div>
                </div>
                <div class="stat-mini">
                    <div class="value">{{ $statistik['talenta'] }}</div>
                    <div class="label">Talenta Terdaftar</div>
                </div>
                <div class="stat-mini">
                   <div class="value">{{ $statistik['client'] }}</div>
                    <div class="label">klien Bergabung</div>
                </div>
                <div class="stat-mini">
                    <div class="value">{{ $statistik['kegiatan'] }}</div>
                    <div class="label">Kegiatan Mendatang</div>
                </div>
            </div>
        </div>
    </section>

    <!-- VISI & MISI -->
    <section class="py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="vm-card">
                    <h3>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Visi
                    </h3>
                    <p>
                        {{-- TODO: ganti dengan visi resmi EJSC Bakorwil --}}
                        Menjadi ekosistem terdepan yang menghubungkan mentor, talenta, dan klien
                        untuk mempercepat pertumbuhan sumber daya manusia di wilayah kerja Bakorwil.
                    </p>
                </div>
                <div class="vm-card">
                    <h3>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Misi
                    </h3>
                    <ul class="list-disc pl-5 space-y-1">
                        {{-- TODO: ganti dengan misi resmi EJSC Bakorwil --}}
                        <li>Menghubungkan mentor berpengalaman dengan talenta yang membutuhkan bimbingan.</li>
                        <li>Membuka akses kolaborasi antara talenta dan klien secara transparan.</li>
                        <li>Memantau pertumbuhan platform secara berkelanjutan melalui data.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CHARTS -->
    <section class="py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="section-heading mb-10">
                <h2 class="hero-title">Pertumbuhan &amp; Distribusi</h2>
                <p class="hero-description">Data ringkas seputar perkembangan mentor, talenta, dan klien kami.</p>
            </div>

            <!-- Pertumbuhan (line chart) -->
            <div class="chart-card mb-6">
                <div class="chart-card-head">
                    <div>
                        <h3>Pertumbuhan Platform</h3>
                        <p class="desc">Jumlah mentor, talenta, dan klien per bulan pada tahun terpilih</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('tentang-kami') }}" class="flex items-center gap-2">
                            <label for="tahun-pertumbuhan" class="text-xs font-medium text-gray-500">Tahun</label>
                            <select id="tahun-pertumbuhan" name="tahun" onchange="this.form.submit()" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 focus:border-[#14b8c4] focus:outline-none focus:ring-2 focus:ring-[#14b8c4]/20">
                                @foreach ($tahunList as $tahunPilihan)
                                    <option value="{{ $tahunPilihan }}" @selected($tahunPilihan === $tahun)>{{ $tahunPilihan }}</option>
                                @endforeach
                            </select>
                        </form>
                        <div class="chart-badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        </div>
                    </div>
                </div>
                <div class="chart-canvas-wrap">
                    <canvas id="chartPertumbuhan"></canvas>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Distribusi per wilayah (doughnut chart) -->
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <h3>Distribusi Per Wilayah</h3>
                            <p class="desc">Setiap warna mewakili total data pada satu wilayah</p>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="chartWilayah"></canvas>
                    </div>
                </div>

                <!-- Perbandingan kategori per wilayah (bar chart) -->
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <h3>Data Per Wilayah</h3>
                            <p class="desc">Perbandingan mentor, talenta, dan UMKM</p>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="chartWilayahBar"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- PROJEK KAMI -->
    <section id="project" class="py-12 relative z-10 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-heading mb-10">
                <span class="inline-flex items-center gap-2 bg-[#eafcfd] px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                    ✦ Projek Kami
                </span>
                        <h2 class="hero-title">Projek yang sedang kami jalankan</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($projectList as $project)
                    @php
                        $projectStatus = [
                            'draft' => ['label' => 'Draft', 'class' => 'bg-amber-100 text-amber-700'],
                            'berjalan' => ['label' => 'Sedang Berjalan', 'class' => 'bg-emerald-100 text-emerald-700'],
                            'selesai' => ['label' => 'Selesai', 'class' => 'bg-slate-100 text-slate-600'],
                            'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-rose-100 text-rose-700'],
                        ][$project->status] ?? ['label' => ucfirst($project->status), 'class' => 'bg-slate-100 text-slate-600'];
                    @endphp
                    <button type="button" class="project-card" data-project-open data-project-name="{{ $project->nama_project }}" data-project-description="{{ $project->output_project ?: 'Informasi project akan segera tersedia.' }}" data-project-image="{{ $project->gambar ? asset('storage/' . $project->gambar) : '' }}" data-project-link="{{ $project->link ?? '' }}">
                        <div class="project-card-cover">
                            @if($project->gambar)
                                <img src="{{ asset('storage/' . $project->gambar) }}" alt="Gambar {{ $project->nama_project }}" class="project-card-image">
                            @else
                                <div class="project-card-mark" aria-hidden="true">EJSC</div>
                            @endif
                            <span class="project-card-year">{{ $project->tahun ?? 'Project' }}</span>
                            <span class="project-card-status {{ $projectStatus['class'] }}">{{ $projectStatus['label'] }}</span>
                        </div>
                        <div class="project-card-body">
                            <div class="project-card-heading">
                                <h3>{{ $project->nama_project }}</h3>
                                <span class="project-card-arrow" aria-hidden="true">↗</span>
                            </div>
                            @if($project->output_project)
                                <p class="project-card-description">{{ Str::limit($project->output_project, 150) }}</p>
                            @endif
                            <p class="project-card-meta">{{ $project->opd }}@if($project->bidang) <span aria-hidden="true">·</span> {{ $project->bidang }}@endif</p>
                            <div class="project-card-footer">
                                <span>{{ $project->mentors->count() + $project->talents->count() + $project->clients->count() }} anggota terlibat</span>
                                <span class="project-card-detail">Lihat detail</span>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12 text-[#7da0ad]">
                        Belum ada projek yang dapat ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="fasilitas-modal" data-project-modal aria-hidden="true">
        <div class="fasilitas-modal-backdrop" data-project-close></div>
        <div class="fasilitas-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="project-modal-title">
            <button type="button" class="fasilitas-modal-close" data-project-close aria-label="Tutup detail projek">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>
            <img src="" alt="" class="fasilitas-modal-image" data-project-modal-image>
            <div class="fasilitas-modal-content">
                <span class="fasilitas-badge">Projek EJSC</span>
                <h2 id="project-modal-title" data-project-modal-name></h2>
                <p data-project-modal-description></p>
                <a href="#" target="_blank" rel="noopener noreferrer" class="inline-flex mt-4 items-center rounded-lg bg-[#14b8c4] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0f9d58]" data-project-modal-link>Lihat Projek Kami</a>
            </div>
        </div>
    </div>

    <!-- FASILITAS -->
    <section id="fasilitas" class="py-12 relative z-10 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-heading mb-10">
                <span class="inline-flex items-center gap-2 bg-[#eafcfd] px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                    ✦ Fasilitas
                </span>
                <h2 class="hero-title">Sarana pendukung yang kami sediakan</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $fasilitasList = [
                        ['nama' => 'Conference Room', 'deskripsi' => 'Ruang konferensi yang nyaman untuk seminar, presentasi, dan kegiatan kolaborasi berskala besar.', 'kategori' => 'Ruang', 'image' => 'resources/images/coference room.jpeg'],
                        ['nama' => 'Coworking Space', 'deskripsi' => 'Area kerja terbuka yang mendukung produktivitas, networking, dan kolaborasi talenta serta klien.', 'kategori' => 'Ruang', 'image' => 'resources/images/cowork.jpeg'],
                        ['nama' => 'Meeting Room', 'deskripsi' => 'Ruang meeting yang tenang untuk rapat, diskusi tim, dan pertemuan dengan mitra.', 'kategori' => 'Ruang', 'image' => 'resources/images/meeting room.jpeg'],
                    ];
                @endphp

                @foreach ($fasilitasList as $item)
                    <button type="button" class="fasilitas-card text-left" data-fasilitas-open data-fasilitas-name="{{ $item['nama'] }}" data-fasilitas-category="{{ $item['kategori'] }}" data-fasilitas-description="{{ $item['deskripsi'] }}" data-fasilitas-image="{{ Vite::asset($item['image']) }}">
                        <div class="fasilitas-image-wrap">
                            <img src="{{ Vite::asset($item['image']) }}" alt="{{ $item['nama'] }}" class="fasilitas-image">
                            <span class="fasilitas-image-badge">{{ $item['kategori'] }}</span>
                        </div>
                        <div class="fasilitas-card-body">
                            <h3>{{ $item['nama'] }}</h3>
                            <p>{{ $item['deskripsi'] }}</p>
                            <div class="fasilitas-card-footer">
                                <span class="fasilitas-badge">{{ $item['kategori'] }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <div class="fasilitas-modal" data-fasilitas-modal aria-hidden="true">
        <div class="fasilitas-modal-backdrop" data-fasilitas-close></div>
        <div class="fasilitas-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="fasilitas-modal-title">
            <button type="button" class="fasilitas-modal-close" data-fasilitas-close aria-label="Tutup detail fasilitas">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>
            <img src="" alt="" class="fasilitas-modal-image" data-fasilitas-modal-image>
            <div class="fasilitas-modal-content">
                <span class="fasilitas-badge" data-fasilitas-modal-category></span>
                <h2 id="fasilitas-modal-title" data-fasilitas-modal-name></h2>
                <p data-fasilitas-modal-description></p>
            </div>
        </div>
    </div>

    <!-- KEGIATAN -->
    <section id="kegiatan" class="py-12 pb-20 relative z-10 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-heading mb-10">
                <span class="inline-flex items-center gap-2 bg-[#eafcfd] px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                    ✦ Kegiatan
                </span>
                <h2 class="hero-title">Agenda dan program yang kami jalankan</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($kegiatanList as $item)
                    <div class="kegiatan-card">
                        <div class="kegiatan-cover">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="kegiatan-status {{ $item['status_class'] }}">{{ $item['status'] }}</span>
                        </div>
                        <div class="kegiatan-body">
                            <div class="kegiatan-tanggal">{{ $item['tanggal'] }}</div>
                            <h3>{{ $item['nama'] }}</h3>
                            <p>{{ Str::limit($item['deskripsi'], 120) }}</p>
                            <div class="kegiatan-meta">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $item['lokasi'] }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12 text-gray-500">
                        Belum ada kegiatan publik yang ditampilkan saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fasilitasModal = document.querySelector('[data-fasilitas-modal]');
        if (fasilitasModal) {
            const modalImage = fasilitasModal.querySelector('[data-fasilitas-modal-image]');
            const modalName = fasilitasModal.querySelector('[data-fasilitas-modal-name]');
            const modalCategory = fasilitasModal.querySelector('[data-fasilitas-modal-category]');
            const modalDescription = fasilitasModal.querySelector('[data-fasilitas-modal-description]');

            const closeFasilitasModal = function () {
                fasilitasModal.classList.remove('is-open');
                fasilitasModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('fasilitas-modal-open');
            };

            document.querySelectorAll('[data-fasilitas-open]').forEach(function (card) {
                card.addEventListener('click', function () {
                    modalImage.src = card.dataset.fasilitasImage;
                    modalImage.alt = card.dataset.fasilitasName;
                    modalName.textContent = card.dataset.fasilitasName;
                    modalCategory.textContent = card.dataset.fasilitasCategory;
                    modalDescription.textContent = card.dataset.fasilitasDescription;
                    fasilitasModal.classList.add('is-open');
                    fasilitasModal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('fasilitas-modal-open');
                });
            });

            fasilitasModal.querySelectorAll('[data-fasilitas-close]').forEach(function (element) {
                element.addEventListener('click', closeFasilitasModal);
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeFasilitasModal();
            });
        }

        const projectModal = document.querySelector('[data-project-modal]');
        if (projectModal) {
            const modalImage = projectModal.querySelector('[data-project-modal-image]');
            const modalName = projectModal.querySelector('[data-project-modal-name]');
            const modalDescription = projectModal.querySelector('[data-project-modal-description]');
            const modalLink = projectModal.querySelector('[data-project-modal-link]');

            const closeProjectModal = function () {
                projectModal.classList.remove('is-open');
                projectModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('fasilitas-modal-open');
            };

            document.querySelectorAll('[data-project-open]').forEach(function (card) {
                card.addEventListener('click', function () {
                    const image = card.dataset.projectImage;
                    modalImage.src = image;
                    modalImage.alt = card.dataset.projectName;
                    modalImage.hidden = !image;
                    modalName.textContent = card.dataset.projectName;
                    modalDescription.textContent = card.dataset.projectDescription || 'Informasi projek akan segera tersedia.';
                    modalLink.href = card.dataset.projectLink;
                    modalLink.hidden = !card.dataset.projectLink;
                    projectModal.classList.add('is-open');
                    projectModal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('fasilitas-modal-open');
                });
            });

            projectModal.querySelectorAll('[data-project-close]').forEach(function (element) {
                element.addEventListener('click', closeProjectModal);
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeProjectModal();
            });
        }

        const pertumbuhan = @json($pertumbuhan);
        const distribusiWilayah = @json($distribusiWilayah);

        if (typeof window.Chart !== 'function') {
            return;
        }

        new window.Chart(document.getElementById('chartPertumbuhan'), {
            type: 'line',
            data: {
                labels: pertumbuhan.labels,
                datasets: [
                    { label: 'Mentor', data: pertumbuhan.mentor, borderColor: '#14b8c4', backgroundColor: 'rgba(20,184,196,0.1)', tension: 0.35, fill: true },
                    { label: 'Talenta', data: pertumbuhan.talenta, borderColor: '#67e8f9', backgroundColor: 'rgba(103,232,249,0.1)', tension: 0.35, fill: true },
                    { label: 'Klien', data: pertumbuhan.client, borderColor: '#0f9d58', backgroundColor: 'rgba(15,157,88,0.1)', tension: 0.35, fill: true },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } },
            },
        });

        new window.Chart(document.getElementById('chartWilayah'), {
            type: 'doughnut',
            data: {
                labels: distribusiWilayah.map((wilayah) => wilayah.label),
                datasets: [{
                        data: distribusiWilayah.map((wilayah) => wilayah.mentor + wilayah.talenta + wilayah.client),
                    backgroundColor: ['#14b8c4', '#67e8f9', '#0f9d58', '#f59e0b', '#7c3aed', '#ef4444', '#3b82f6'],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const wilayah = distribusiWilayah[context.dataIndex];
                                return [
                                    'Total: ' + context.raw,
                                    'Mentor: ' + wilayah.mentor,
                                    'Talenta: ' + wilayah.talenta,
                                    'UMKM: ' + wilayah.client,
                                ];
                            },
                        },
                    },
                },
            },
        });

        new window.Chart(document.getElementById('chartWilayahBar'), {
            type: 'bar',
            data: {
                labels: distribusiWilayah.map((wilayah) => wilayah.label),
                datasets: [
                    { label: 'Mentor', data: distribusiWilayah.map((wilayah) => wilayah.mentor), backgroundColor: '#14b8c4', borderRadius: 5 },
                    { label: 'Talenta', data: distribusiWilayah.map((wilayah) => wilayah.talenta), backgroundColor: '#67e8f9', borderRadius: 5 },
                    { label: 'UMKM', data: distribusiWilayah.map((wilayah) => wilayah.client), backgroundColor: '#0f9d58', borderRadius: 5 },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { ticks: { maxRotation: 45, minRotation: 0 } },
                },
                plugins: { legend: { position: 'bottom' } },
            },
        });
    });
</script>
@endsection
