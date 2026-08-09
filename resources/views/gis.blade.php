@extends('layouts.app')

@section('title', 'GIS Map Bakorwil - EJSC Bakorwil')

@section('content')
<section class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Peta Wilayah Bakorwil</h1>
        <p class="text-lg text-indigo-100">Sistem Informasi Geografis 7 Daerah Bakorwil Jawa Timur - Tapal Kuda</p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Map Container -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Peta Sebaran Wilayah</h2>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">7 Wilayah</span>
                    </div>

                    <!-- SVG Map -->
                    <div class="relative">
                        <svg id="gis-map" viewBox="0 0 1000 700" class="w-full h-auto drop-shadow-lg" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Peta wilayah Bakorwil">
                            <!-- Background water -->
                            <rect x="0" y="0" width="1000" height="700" fill="#E3F2FD" rx="16"/>

                            <!-- Decorative compass -->
                            <g transform="translate(880, 60)" opacity="0.6">
                                <circle cx="0" cy="0" r="28" fill="white" stroke="#94a3b8" stroke-width="1.5"/>
                                <line x1="0" y1="-24" x2="0" y2="24" stroke="#94a3b8" stroke-width="1.5"/>
                                <line x1="-24" y1="0" x2="24" y2="0" stroke="#94a3b8" stroke-width="1.5"/>
                                <polygon points="0,-22 -7,0 7,0" fill="#ef4444"/>
                                <polygon points="0,22 -6,0 6,0" fill="#94a3b8"/>
                                <text x="0" y="-34" text-anchor="middle" font-size="12" font-weight="bold" fill="#ef4444">U</text>
                            </g>

                            <!-- Region tooltip -->
                            <g id="map-tooltip" style="display: none; pointer-events: none;">
                                <rect id="map-tooltip-box" x="0" y="0" width="180" height="52" rx="8" fill="#1f2937" opacity="0.95"/>
                                <text id="map-tooltip-title" x="90" y="20" text-anchor="middle" fill="#fff" font-size="14" font-weight="bold"></text>
                                <text id="map-tooltip-sub" x="90" y="40" text-anchor="middle" fill="#9ca3af" font-size="11"></text>
                            </g>

                            <!-- ============ WILAYAH POLYGONS ============ -->

<!-- Probolinggo Kota -->
                            <g class="region" data-region="kota" data-name="Kota Probolinggo" data-type="Kota"
                               transform="translate(0,0)">
                                <path d="M 250,42 L 328,32 L 348,112 L 285,132 L 232,102 Z"
                                      fill="#F59E0B" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="290" y="88" text-anchor="middle" fill="#fff" font-size="15" font-weight="bold" class="region-label">Kota Probolinggo</text>
                            </g>

                            <!-- Probolinggo -->
                            <g class="region" data-region="probolinggo" data-name="Kabupaten Probolinggo" data-type="Kabupaten"
                               transform="translate(0,0)">
                                <path d="M 60,120 L 200,112 L 320,96 L 360,180 L 340,260 L 258,300 L 148,282 L 78,200 Z"
                                      fill="#EF4444" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="205" y="205" text-anchor="middle" fill="#fff" font-size="18" font-weight="bold" class="region-label">Probolinggo</text>
                            </g>

                            <!-- Lumajang -->
                            <g class="region" data-region="lumajang" data-name="Kabupaten Lumajang" data-type="Kabupaten"
                               transform="translate(0,0)">
                                <path d="M 130,300 L 260,282 L 350,340 L 340,460 L 282,540 L 170,522 L 112,430 Z"
                                      fill="#8B5CF6" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="235" y="420" text-anchor="middle" fill="#fff" font-size="18" font-weight="bold" class="region-label">Lumajang</text>
                            </g>

                            <!-- Situbondo -->
                            <g class="region" data-region="situbondo" data-name="Kabupaten Situbondo" data-type="Kabupaten"
                               transform="translate(0,0)">
                                <path d="M 480,60 L 620,50 L 740,90 L 730,170 L 640,200 L 540,180 L 470,120 Z"
                                      fill="#10B981" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="604" y="130" text-anchor="middle" fill="#fff" font-size="18" font-weight="bold" class="region-label">Situbondo</text>
                            </g>

                            <!-- Bondowoso -->
                            <g class="region" data-region="bondowoso" data-name="Kabupaten Bondowoso" data-type="Kabupaten"
                               transform="translate(0,0)">
                                <path d="M 360,180 L 480,160 L 600,200 L 610,300 L 550,380 L 450,400 L 360,340 L 340,240 Z"
                                      fill="#3B82F6" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="480" y="285" text-anchor="middle" fill="#fff" font-size="18" font-weight="bold" class="region-label">Bondowoso</text>
                            </g>

                            <!-- Jember -->
                            <g class="region" data-region="jember" data-name="Kabupaten Jember" data-type="Kabupaten"
                               transform="translate(0,0)">
                                <path d="M 320,380 L 440,360 L 580,380 L 650,460 L 610,600 L 480,620 L 360,580 L 300,500 Z"
                                      fill="#F97316" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="480" y="500" text-anchor="middle" fill="#fff" font-size="18" font-weight="bold" class="region-label">Jember</text>
                            </g>

                            <!-- Banyuwangi -->
                            <g class="region" data-region="banyuwangi" data-name="Kabupaten Banyuwangi" data-type="Kabupaten"
                               transform="translate(0,0)">
                                <path d="M 700,220 L 820,200 L 920,260 L 940,400 L 900,540 L 860,660 L 740,680 L 680,580 L 680,360 Z"
                                      fill="#EC4899" stroke="#ffffff" stroke-width="3" stroke-linejoin="round"
                                      class="region-fill"/>
                                <text x="800" y="450" text-anchor="middle" fill="#fff" font-size="18" font-weight="bold" class="region-label">Banyuwangi</text>
                            </g>
                        </svg>

                        <!-- Floating info panel -->
                        <div id="info-panel" class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur rounded-xl shadow-xl border border-gray-200 p-4 hidden">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 id="info-name" class="text-lg font-bold text-gray-900"></h3>
                                    <p id="info-type" class="text-sm font-medium text-indigo-600 mb-1"></p>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span id="info-color" class="w-4 h-4 rounded"></span>
                                        <span id="info-area" class="text-sm text-gray-600"></span>
                                    </div>
                                    <p id="info-desc" class="text-sm text-gray-600 w-3/4"></p>
                                </div>
                                <button id="info-close" class="text-gray-400 hover:text-gray-600 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 mt-4 text-center">Klik wilayah pada peta untuk melihat detail. Hover untuk menyorot.</p>
                </div>
            </div>

            <!-- Sidebar / Legend -->
            <div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Legend Wilayah</h3>
                    <div id="region-list" class="space-y-3">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white">
                    <h3 class="text-lg font-bold mb-3">Tentang Bakorwil</h3>
                    <p class="text-sm text-indigo-100 leading-relaxed">
                        Bakorwil (Badan Koordinasi Wilayah) membawahi 7 daerah di wilayah Tapal Kuda Jawa Timur yang meliputi:
                        Kota Probolinggo, Kabupaten Probolinggo, Lumajang, Jember, Bondowoso, Situbondo, dan Banyuwangi.
                    </p>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <p class="text-sm font-semibold mb-2">Total Wilayah</p>
                        <p class="text-3xl font-bold text-yellow-400">7 Daerah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const REGIONS = {
        kota: {
            name: 'Kota Probolinggo',
            type: 'Kota',
            color: '#F59E0B',
            area: '±56,67 km²',
            desc: 'Kota pelabuhan dan pusat industri di pesisir utara yang menjadi pintu gerbang kawasan Tapal Kuda.',
        },
        probolinggo: {
            name: 'Kabupaten Probolinggo',
            type: 'Kabupaten',
            color: '#EF4444',
            area: '±1.696 km²',
            desc: 'Kabupaten dengan sektor pertanian dan perikanan tangkap yang kuat, termasuk kawasan Gunung Bromo.',
        },
        lumajang: {
            name: 'Kabupaten Lumajang',
            type: 'Kabupaten',
            color: '#8B5CF6',
            area: '±1.791 km²',
            desc: 'Dikenal sebagai lumbung pertanian dan penghasil pangan, dikelilingi Gunung Semeru.',
        },
        jember: {
            name: 'Kabupaten Jember',
            type: 'Kabupaten',
            color: '#F97316',
            area: '±3.293 km²',
            desc: 'Pusat industri tembakau dan perkebunan terbesar, dijuluki Kota Tembakau.',
        },
        bondowoso: {
            name: 'Kabupaten Bondowoso',
            type: 'Kabupaten',
            color: '#3B82F6',
            area: '±1.560 km²',
            desc: 'Dataran tinggi dengan pertanian subur dan dikenal sebagai Kota Tape.',
        },
        situbondo: {
            name: 'Kabupaten Situbondo',
            type: 'Kabupaten',
            color: '#10B981',
            area: '±1.669 km²',
            desc: 'Wilayah pesisir utara dengan potensi perikanan dan wisata pantai.',
        },
        banyuwangi: {
            name: 'Kabupaten Banyuwangi',
            type: 'Kabupaten',
            color: '#EC4899',
            area: '±5.783 km²',
            desc: 'Kawasan paling timur Pulau Jawa, pusat wisata alam dan budidaya kopi.',
        },
    };

    const svg = document.getElementById('gis-map');
    const tooltip = document.getElementById('map-tooltip');
    const tooltipBox = document.getElementById('map-tooltip-box');
    const tooltipTitle = document.getElementById('map-tooltip-title');
    const tooltipSub = document.getElementById('map-tooltip-sub');

    const infoPanel = document.getElementById('info-panel');
    const infoName = document.getElementById('info-name');
    const infoType = document.getElementById('info-type');
    const infoColor = document.getElementById('info-color');
    const infoArea = document.getElementById('info-area');
    const infoDesc = document.getElementById('info-desc');

    const regionList = document.getElementById('region-list');

    // Build legend list
    Object.entries(REGIONS).forEach(([key, r]) => {
        const item = document.createElement('div');
        item.className = 'region-item flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-gray-50 transition group';
        item.dataset.region = key;
        item.innerHTML = `
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0" style="background:${r.color}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600">${r.name}</p>
                <p class="text-xs text-gray-500">${r.type} · ${r.area}</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        `;
        item.addEventListener('click', () => selectRegion(key));
        item.addEventListener('mouseenter', () => highlightRegion(key));
        item.addEventListener('mouseleave', clearHighlight);
        regionList.appendChild(item);
    });

    // Highlight a region polygon
    function highlightRegion(key) {
        document.querySelectorAll('.region').forEach(g => {
            const fill = g.querySelector('.region-fill');
            fill.style.filter = g.dataset.region === key ? 'brightness(1.15) drop-shadow(0 0 6px rgba(0,0,0,0.3))' : 'none';
        });
    }

    function clearHighlight() {
        document.querySelectorAll('.region-fill').forEach(f => f.style.filter = 'none');
    }

    // Select region -> show info
    function selectRegion(key) {
        const r = REGIONS[key];
        infoName.textContent = r.name;
        infoType.textContent = r.type;
        infoArea.textContent = `Luas: ${r.area}`;
        infoDesc.textContent = r.desc;
        infoColor.style.background = r.color;
        infoPanel.classList.remove('hidden');
        highlightRegion(key);
    }

    // Region interactions on SVG
    document.querySelectorAll('.region').forEach(g => {
        g.addEventListener('mouseenter', (e) => {
            const key = g.dataset.region;
            const r = REGIONS[key];
            highlightRegion(key);
            tooltipTitle.textContent = r.name;
            tooltipSub.textContent = r.type + ' · ' + r.area;
            tooltip.style.display = 'block';
        });

        g.addEventListener('mousemove', (e) => {
            const pt = svg.createSVGPoint();
            pt.x = e.clientX;
            pt.y = e.clientY;
            const svgPt = pt.matrixTransform(svg.getScreenCTM().inverse());
            tooltip.setAttribute('transform', `translate(${svgPt.x - 90}, ${svgPt.y - 70})`);
        });

        g.addEventListener('mouseleave', () => {
            tooltip.style.display = 'none';
            clearHighlight();
        });

        g.addEventListener('click', () => selectRegion(g.dataset.region));
    });

    // Close info panel
    document.getElementById('info-close').addEventListener('click', () => {
        infoPanel.classList.add('hidden');
        clearHighlight();
    });
</script>
@endsection
