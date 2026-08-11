@extends('layouts.app')

@section('title', 'EJSC Bakorwil - Platform Mentor, Talenta & Client')

@section('content')

<!-- ============================================ -->
<!-- GIS MAP SECTION (Full-Width, Top of Landing) -->
<!-- ============================================ -->
<section id="gis-section" class="relative w-full bg-[#0e4f81]">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Map Header Bar -->
    <div class="absolute top-0 left-0 right-0 z-20 bg-gradient-to-r from-sky-200 via-cyan-200 to-slate-100 text-slate-900 px-6 py-4 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl lg:text-2xl font-bold">Peta Wilayah Bakorwil</h1>
                <p class="text-sm text-slate-700">Sistem Informasi Geografis 7 Daerah Tapal Kuda - Jawa Timur</p>
            </div>
            <span class="hidden sm:inline-flex items-center px-3 py-1 bg-yellow-400 text-teal-900 text-xs font-bold rounded-full">
                <span class="w-2 h-2 bg-teal-700 rounded-full mr-2 animate-pulse"></span>
                QGIS Map
            </span>
        </div>
    </div>

    <!-- Leaflet Map Container (full width, large height) -->
    <div id="qgis-map" class="w-full relative z-0" style="height: 80vh; background: linear-gradient(180deg, #0d4f7a 0%, #4ba3e1 100%);"></div>

<!-- Placeholder Overlay (shown until GeoJSON data is loaded) -->
    <div id="gis-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 text-slate-900" style="background: linear-gradient(135deg, rgba(173,216,230,0.96), rgba(199,229,255,0.96)); z-index: 10;">
        <div class="w-20 h-20 bg-white/15 border border-yellow-400/50 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 mb-3">Tempat Peta QGIS</h2>
        <p class="text-slate-700 max-w-xl mb-6 leading-relaxed">
            Area ini disiapkan untuk menampilkan peta interaktif hasil QGIS.
            Unggah file <span class="font-mono text-yellow-300">GeoJSON</span> hasil ekspor QGIS ke
            <span class="font-mono text-yellow-300">public/maps/bakorwil.geojson</span>
            untuk menampilkan 7 daerah Tapal Kuda secara interaktif.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
            <button onclick="loadQGISData()" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-teal-900 font-bold rounded-lg transition shadow-lg">
                Muat Data Peta
            </button>
            <a href="#after-gis" class="px-6 py-3 bg-white border border-slate-300 text-slate-900 font-semibold rounded-lg hover:bg-slate-100 transition">
                Lihat Layanan
            </a>
        </div>
    </div>

    <!-- Map Info Panel (populated on region click) -->
    <div id="qgis-info" class="absolute bottom-4 left-4 right-4 md:right-auto md:max-w-sm bg-white/95 backdrop-blur rounded-xl shadow-xl border border-teal-200 p-4 hidden" style="z-index: 20;">
        <div class="flex items-start justify-between">
            <div>
                <h3 id="qgis-info-name" class="text-lg font-bold text-teal-900"></h3>
                <p id="qgis-info-type" class="text-sm font-medium text-teal-600 mb-1"></p>
                <p id="qgis-info-desc" class="text-sm text-gray-600"></p>
            </div>
            <button onclick="document.getElementById('qgis-info').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Anchor so the hero follows the full-width map -->
<a id="after-gis" class="block"></a>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-sky-200 via-cyan-100 to-slate-100 text-slate-900 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-sky-300 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-200 rounded-full blur-3xl opacity-30"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/90 border border-sky-300/40 text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-sky-600 rounded-full mr-2 animate-pulse"></span>
                    Platform Resmi EJSC Bakorwil
                </span>
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                    Menghubungkan <span class="text-sky-700">Mentor</span>, <span class="text-sky-700">Talenta</span> & <span class="text-sky-700">Client</span>
                </h1>
                <p class="text-lg lg:text-xl text-slate-700 mb-8 leading-relaxed">
                    Platform terpercaya untuk menemukan mentor berpengalaman, mengembangkan talenta terbaik, dan menghubungkan dengan client yang tepat.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('mentor') }}" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-teal-900 font-bold rounded-lg hover:bg-yellow-300 transition shadow-lg">
                        Cari Mentor
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                        </svg>
                    </a>
                    <a href="{{ route('talenta') }}" class="inline-flex items-center px-6 py-3 bg-white border border-slate-300 text-slate-900 font-semibold rounded-lg hover:bg-slate-100 transition">
                        Lihat Talenta
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl p-8 border border-sky-200/60 shadow-2xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold">Statistik Platform</h3>
                        <span class="px-3 py-1 bg-sky-200/50 text-sky-700 text-xs font-medium rounded-full">Live</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/80 rounded-xl p-4">
                            <p class="text-3xl font-bold text-sky-700">150+</p>
                            <p class="text-sm text-slate-700 mt-1">Mentor</p>
                        </div>
                        <div class="bg-white/80 rounded-xl p-4">
                            <p class="text-3xl font-bold text-sky-700">500+</p>
                            <p class="text-sm text-slate-700 mt-1">Talenta</p>
                        </div>
                        <div class="bg-white/80 rounded-xl p-4">
                            <p class="text-3xl font-bold text-sky-700">80+</p>
                            <p class="text-sm text-slate-700 mt-1">Client</p>
                        </div>
                        <div class="bg-white/80 rounded-xl p-4">
                            <p class="text-3xl font-bold text-sky-700">98%</p>
                            <p class="text-sm text-slate-700 mt-1">Kepuasan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Layanan Kami</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Tiga pilar utama yang menghubungkan kebutuhan Anda dalam satu platform</p>
        </div>
<div class="grid md:grid-cols-3 gap-8">
            <!-- Mentor -->
            <div class="bg-teal-50/60 rounded-2xl p-8 hover:shadow-xl transition group border border-teal-100">
                <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-teal-600 transition">
                    <svg class="w-7 h-7 text-teal-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Mentor</h3>
                <p class="text-gray-600 mb-6">Temukan mentor berpengalaman di berbagai bidang untuk membimbing pengembangan karier dan skill Anda.</p>
                <a href="{{ route('mentor') }}" class="inline-flex items-center text-teal-600 font-medium hover:text-teal-700">
                    Lihat Mentor
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Talenta -->
            <div class="bg-teal-50/60 rounded-2xl p-8 hover:shadow-xl transition group border border-teal-100">
                <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-teal-600 transition">
                    <svg class="w-7 h-7 text-teal-600 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Talenta</h3>
                <p class="text-gray-600 mb-6">Jelajahi talenta terbaik dengan keahlian dan potensi luar biasa yang siap berkontribusi untuk Anda.</p>
                <a href="{{ route('talenta') }}" class="inline-flex items-center text-teal-600 font-medium hover:text-teal-700">
                    Lihat Talenta
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Client -->
            <div class="bg-teal-50/60 rounded-2xl p-8 hover:shadow-xl transition group border border-teal-100">
                <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-yellow-400 transition">
                    <svg class="w-7 h-7 text-yellow-600 group-hover:text-teal-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Client</h3>
                <p class="text-gray-600 mb-6">Terhubung dengan client yang membutuhkan layanan dan keahlian terbaik untuk proyek Anda.</p>
                <a href="{{ route('client') }}" class="inline-flex items-center text-yellow-600 font-medium hover:text-yellow-700">
                    Lihat Client
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-20 bg-sky-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Cara Kerja</h2>
            <p class="text-lg text-slate-700">Langkah mudah untuk memulai bersama kami</p>
        </div>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-sky-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-4 shadow-lg">1</div>
                <h3 class="font-semibold text-slate-900 mb-2">Daftar</h3>
                <p class="text-slate-700 text-sm">Buat akun dan lengkapi profil Anda</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-sky-200 text-slate-900 rounded-2xl flex items-center justify-center text-2xl font-bold mb-4 shadow-lg">2</div>
                <h3 class="font-semibold text-slate-900 mb-2">Pilih</h3>
                <p class="text-slate-700 text-sm">Pilih mentor, talenta, atau client sesuai kebutuhan</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-sky-600 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-4 shadow-lg">3</div>
                <h3 class="font-semibold text-slate-900 mb-2">Terhubung</h3>
                <p class="text-slate-700 text-sm">Mulai kolaborasi dan komunikasi langsung</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-sky-200 text-slate-900 rounded-2xl flex items-center justify-center text-2xl font-bold mb-4 shadow-lg">4</div>
                <h3 class="font-semibold text-slate-900 mb-2">Berkembang</h3>
                <p class="text-slate-700 text-sm">Kembangkan karier dan bisnis bersama kami</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-sky-200 via-cyan-100 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Siap Memulai?</h2>
        <p class="text-lg text-slate-700 mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan pengguna yang telah merasakan manfaat platform kami</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('kelola.mentor') }}" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg">Kelola Data</a>
            <a href="{{ route('client') }}" class="px-8 py-3 bg-white border-2 border-slate-300 text-slate-900 font-semibold rounded-lg hover:bg-slate-100 transition">Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let qgisMap = null;
    let geoLayer = null;

    // Initialize the Leaflet map once
    function initQGISMap() {
        if (qgisMap) return;

        qgisMap = L.map('qgis-map', {
            center: [-8.0, 113.8], // Tapal Kuda region
            zoom: 8,
            scrollWheelZoom: true,
        });

        // Base tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(qgisMap);

        // Ensure map resizes correctly inside the section
        setTimeout(() => qgisMap.invalidateSize(), 200);
    }

    // Load GeoJSON data exported from QGIS
    function loadQGISData() {
        initQGISMap();

        // Path to the GeoJSON file exported from QGIS
        const geoJsonPath = '/maps/bakorwil.geojson';

        fetch(geoJsonPath)
            .then(res => {
                if (!res.ok) throw new Error('File GeoJSON belum tersedia');
                return res.json();
            })
            .then(data => {
                // Remove existing layer if any
                if (geoLayer) {
                    qgisMap.removeLayer(geoLayer);
                }

// Style polygons (teal dominant theme)
                geoLayer = L.geoJSON(data, {
                    style: {
                        color: '#ffffff',
                        weight: 2,
                        fillColor: '#0d9488', // teal-600
                        fillOpacity: 0.55,
                    },
                    onEachFeature: (feature, layer) => {
                        const props = feature.properties || {};
                        const name = props.NAME || props.name || 'Wilayah';
                        const type = props.TYPE || props.type || '';

                        layer.bindPopup(`<strong>${name}</strong>${type ? '<br><small>' + type + '</small>' : ''}`);

                        layer.on('mouseover', () => {
                            layer.setStyle({
                                fillColor: '#f59e0b',
                                fillOpacity: 0.8,
                                weight: 3,
                            });
                        });
                        layer.on('mouseout', () => {
                            geoLayer.resetStyle(layer);
                        });
                        layer.on('click', () => {
                            document.getElementById('qgis-info-name').textContent = name;
                            document.getElementById('qgis-info-type').textContent = type;
                            document.getElementById('qgis-info-desc').textContent =
                                props.DESCRIPTION || props.desc || 'Detail wilayah belum tersedia.';
                            document.getElementById('qgis-info').classList.remove('hidden');
                        });
                    },
                }).addTo(qgisMap);

                // Fit map to the loaded data
                qgisMap.fitBounds(geoLayer.getBounds());

                // Hide the placeholder overlay
                document.getElementById('gis-placeholder').style.display = 'none';
            })
            .catch(err => {
                alert('Gagal memuat peta: ' + err.message + '\n\nTempatkan file GeoJSON hasil ekspor QGIS di: public/maps/bakorwil.geojson');
            });
    }

    // Auto-initialize map when the page loads (shows base map behind placeholder)
    // Do not initialize the Leaflet map until the user loads QGIS data.
    // This keeps the landing page in its original QGIS placeholder state.
</script>
@endsection
