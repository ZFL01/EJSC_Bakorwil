@extends('layouts.app')

@section('title', 'Fasilitas - EJSC Bakorwil')

@section('content')

<div class="fasilitas-page">

    <!-- HERO -->
    <section class="fasilitas-hero py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 bg-white/70 px-4 py-1.5 rounded-full text-sm font-medium text-[#14b8c4] mb-4">
                ✦ Fasilitas Kami
            </span>
            <h1 class="hero-title text-4xl font-bold mb-4">
                Fasilitas <span>EJSC Bakorwil</span>
            </h1>
            <p class="hero-description text-lg max-w-2xl mx-auto">
                Sarana dan prasarana yang kami sediakan untuk mendukung kegiatan mentoring,
                pelatihan, dan pengembangan talenta secara maksimal.
            </p>
        </div>
    </section>

    <!-- LIST FASILITAS -->
    <section class="py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                @php
                    // TODO: nanti bisa diganti dengan data dari database (Fasilitas::all())
                    $fasilitasList = [
                        [
                            'nama' => 'Ruang Mentoring',
                            'deskripsi' => 'Ruang tatap muka nyaman untuk sesi bimbingan satu-ke-satu antara mentor dan talenta.',
                            'kategori' => 'Ruang',
                            'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4',
                        ],
                        [
                            'nama' => 'Coworking Space',
                            'deskripsi' => 'Area kerja terbuka yang bisa digunakan talenta dan client untuk berkolaborasi setiap hari.',
                            'kategori' => 'Ruang',
                            'icon' => 'M3 7h18M3 12h18M3 17h18',
                        ],
                        [
                            'nama' => 'Ruang Pelatihan',
                            'deskripsi' => 'Dilengkapi proyektor, sound system, dan kapasitas hingga 50 peserta untuk workshop dan training.',
                            'kategori' => 'Ruang',
                            'icon' => 'M9 20h6M12 4v16m8-8H4',
                        ],
                        [
                            'nama' => 'Perpustakaan Digital',
                            'deskripsi' => 'Akses ke koleksi materi belajar, modul, dan referensi digital untuk menunjang pengembangan diri.',
                            'kategori' => 'Sumber Daya',
                            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s4.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                        ],
                        [
                            'nama' => 'Aula Serbaguna',
                            'deskripsi' => 'Ruang besar untuk seminar, sesi networking, dan acara komunitas EJSC Bakorwil.',
                            'kategori' => 'Ruang',
                            'icon' => 'M4 6h16M4 12h16M4 18h7',
                        ],
                        [
                            'nama' => 'Area Diskusi & Kolaborasi',
                            'deskripsi' => 'Ruang santai dengan papan tulis dan alat presentasi untuk brainstorming tim kecil.',
                            'kategori' => 'Ruang',
                            'icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l1.586-1.586z',
                        ],
                        [
                            'nama' => 'Wi-Fi & Jaringan Cepat',
                            'deskripsi' => 'Koneksi internet berkecepatan tinggi tersedia di seluruh area gedung EJSC Bakorwil.',
                            'kategori' => 'Sumber Daya',
                            'icon' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M4.929 12.929a10 10 0 0114.142 0',
                        ],
                        [
                            'nama' => 'Kantin & Area Istirahat',
                            'deskripsi' => 'Tempat bersantai dan menikmati makanan/minuman di sela-sela kegiatan mentoring.',
                            'kategori' => 'Penunjang',
                            'icon' => 'M3 3h18M4 3v10a4 4 0 004 4h8a4 4 0 004-4V3M9 21v-4a3 3 0 016 0v4',
                        ],
                        [
                            'nama' => 'Area Parkir',
                            'deskripsi' => 'Tersedia area parkir yang luas dan aman bagi mentor, talenta, dan client yang berkunjung.',
                            'kategori' => 'Penunjang',
                            'icon' => 'M19 17h2l-1.5-4.5M5 17H3l1.5-4.5M5 17v2a1 1 0 001 1h1a1 1 0 001-1v-2m8 0v2a1 1 0 001 1h1a1 1 0 001-1v-2M5 17h14l-1.5-6a2 2 0 00-1.9-1.5H8.4A2 2 0 006.5 11L5 17z',
                        ],
                    ];
                @endphp

                @foreach ($fasilitasList as $item)
                    <div class="fasilitas-card">
                        <div class="fasilitas-icon">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                            </svg>
                        </div>
                        <h3>{{ $item['nama'] }}</h3>
                        <p>{{ $item['deskripsi'] }}</p>
                        <span class="fasilitas-badge">{{ $item['kategori'] }}</span>
                    </div>
                @endforeach

            </div>

        </div>
    </section>

</div>

@endsection