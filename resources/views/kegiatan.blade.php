@extends('layouts.app')

@section('title', 'Kegiatan - EJSC Bakorwil')

@section('content')

<div class="kegiatan-page">

    <!-- HERO -->
    <section class="kegiatan-hero py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 bg-white/70 px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                ✦ Agenda EJSC
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
            <div class="mb-8 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                <div class="relative md:w-80">
                    <svg class="w-5 h-5 text-[#7da0ad] absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search-input" type="text" placeholder="Cari kegiatan..."
                        class="kegiatan-search w-full pl-10 pr-4 py-2.5 border border-[#d5ebee] rounded-xl bg-white placeholder-[#8ba4af] focus:outline-none">
                </div>

                <select id="filter-select" class="kegiatan-filter px-4 py-2.5 border border-[#d5ebee] rounded-xl bg-white focus:outline-none">
                    <option value="semua">Semua Status</option>
                    <option value="akan-datang">Akan Datang</option>
                    <option value="berlangsung">Berlangsung</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div id="kegiatan-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Kegiatan cards dirender oleh JavaScript -->
            </div>

            <div id="empty-state" class="hidden text-center py-16 text-[#7da0ad]">
                Tidak ada kegiatan yang cocok dengan pencarian.
            </div>

        </div>
    </section>

</div>

<script>
    // TODO: nanti bisa diganti dengan data dari database (Kegiatan::all())
    const kegiatanData = [
        {
            nama: 'Workshop AI untuk Pemula',
            tanggal: '25 Agustus 2026',
            lokasi: 'Ruang Pelatihan, EJSC Bakorwil',
            status: 'akan-datang',
            deskripsi: 'Pengenalan konsep dasar AI dan machine learning untuk talenta yang baru memulai.'
        },
        {
            nama: 'Sesi Mentoring Karier Bersama Client',
            tanggal: '30 Agustus 2026',
            lokasi: 'Ruang Mentoring',
            status: 'akan-datang',
            deskripsi: 'Sesi konsultasi karier langsung antara talenta terpilih dengan perwakilan client.'
        },
        {
            nama: 'Bootcamp UI/UX Design',
            tanggal: '14 - 16 Agustus 2026',
            lokasi: 'Coworking Space',
            status: 'berlangsung',
            deskripsi: 'Pelatihan intensif 3 hari membahas riset pengguna, wireframing, hingga prototyping.'
        },
        {
            nama: 'Seminar Kewirausahaan Digital',
            tanggal: '5 Agustus 2026',
            lokasi: 'Aula Serbaguna',
            status: 'selesai',
            deskripsi: 'Berbagi wawasan dari para praktisi tentang membangun bisnis digital dari nol.'
        },
        {
            nama: 'Talkshow Networking Mentor & Talenta',
            tanggal: '28 Juli 2026',
            lokasi: 'Aula Serbaguna',
            status: 'selesai',
            deskripsi: 'Ajang perkenalan dan diskusi santai antara mentor baru dengan talenta EJSC Bakorwil.'
        },
        {
            nama: 'Pelatihan Public Speaking',
            tanggal: '10 September 2026',
            lokasi: 'Ruang Pelatihan',
            status: 'akan-datang',
            deskripsi: 'Melatih kepercayaan diri dan kemampuan komunikasi di depan umum.'
        },
    ];

    const statusLabel = {
        'akan-datang': { label: 'Akan Datang', class: 'status-akan-datang' },
        'berlangsung': { label: 'Berlangsung', class: 'status-berlangsung' },
        'selesai': { label: 'Selesai', class: 'status-selesai' },
    };

    const searchInput = document.getElementById('search-input');
    const filterSelect = document.getElementById('filter-select');
    const kegiatanList = document.getElementById('kegiatan-list');
    const emptyState = document.getElementById('empty-state');

    function renderKegiatan() {
        const keyword = searchInput.value.toLowerCase();
        const status = filterSelect.value;

        const filtered = kegiatanData.filter((item) => {
            const matchKeyword = item.nama.toLowerCase().includes(keyword) ||
                                  item.deskripsi.toLowerCase().includes(keyword);
            const matchStatus = status === 'semua' || item.status === status;
            return matchKeyword && matchStatus;
        });

        kegiatanList.innerHTML = '';

        if (filtered.length === 0) {
            emptyState.classList.remove('hidden');
            return;
        }
        emptyState.classList.add('hidden');

        filtered.forEach((item) => {
            const st = statusLabel[item.status];
            const card = document.createElement('div');
            card.className = 'kegiatan-card';
            card.innerHTML = `
                <div class="kegiatan-cover">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="kegiatan-status ${st.class}">${st.label}</span>
                </div>
                <div class="kegiatan-body">
                    <div class="kegiatan-tanggal">${item.tanggal}</div>
                    <h3>${item.nama}</h3>
                    <p>${item.deskripsi}</p>
                    <div class="kegiatan-meta">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        ${item.lokasi}
                    </div>
                </div>
            `;
            kegiatanList.appendChild(card);
        });
    }

    searchInput.addEventListener('input', renderKegiatan);
    filterSelect.addEventListener('change', renderKegiatan);
    renderKegiatan();
</script>

@endsection