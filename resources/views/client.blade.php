@extends('layouts.app')

@section('title', 'Daftar Client - EJSC Bakorwil')

@section('content')
<section class="bg-gradient-to-r from-green-600 to-teal-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Daftar Client</h1>
        <p class="text-lg text-green-100">Terhubung dengan client yang membutuhkan layanan dan keahlian terbaik</p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                <div class="relative md:w-80">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search-input" type="text" placeholder="Cari client..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                </div>
                <div class="flex items-center gap-3">
                    <select id="filter-select" class="px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500">
                        <option value="semua">Semua Kategori</option>
                        <option value="korporasi">Korporasi</option>
                        <option value="startup">Startup</option>
                        <option value="umkm">UMKM</option>
                        <option value="pemerintahan">Pemerintahan</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="client-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Client cards rendered by JS -->
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Client tidak ditemukan</h3>
            <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter kategori</p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    const clients = [
        { nama: 'PT Maju Bersama', kategori: 'korporasi', industri: 'Manufaktur', proyek: 25, avatar: 'MB' },
        { nama: 'Startup Inovasi', kategori: 'startup', industri: 'Teknologi', proyek: 12, avatar: 'SI' },
        { nama: 'CV Karya Mandiri', kategori: 'umkm', industri: 'Kuliner', proyek: 8, avatar: 'KM' },
        { nama: 'Dinas Pendidikan', kategori: 'pemerintahan', industri: 'Pendidikan', proyek: 15, avatar: 'DP' },
        { nama: 'PT Solusi Digital', kategori: 'korporasi', industri: 'IT Services', proyek: 30, avatar: 'SD' },
        { nama: 'Startup Fintech', kategori: 'startup', industri: 'Keuangan', proyek: 10, avatar: 'SF' },
        { nama: 'Toko Berkah', kategori: 'umkm', industri: 'Retail', proyek: 5, avatar: 'TB' },
        { nama: 'Bank Daerah', kategori: 'pemerintahan', industri: 'Perbankan', proyek: 18, avatar: 'BD' },
        { nama: 'PT Global Media', kategori: 'korporasi', industri: 'Media', proyek: 22, avatar: 'GM' },
    ];

    const kategoriLabel = {
        korporasi: { label: 'Korporasi', color: 'bg-blue-100 text-blue-700' },
        startup: { label: 'Startup', color: 'bg-purple-100 text-purple-700' },
        umkm: { label: 'UMKM', color: 'bg-green-100 text-green-700' },
        pemerintahan: { label: 'Pemerintahan', color: 'bg-yellow-100 text-yellow-700' },
    };

    const searchInput = document.getElementById('search-input');
    const filterSelect = document.getElementById('filter-select');
    const clientList = document.getElementById('client-list');
    const emptyState = document.getElementById('empty-state');

    function renderClients() {
        const keyword = searchInput.value.toLowerCase();
        const kategori = filterSelect.value;

        const filtered = clients.filter(c => {
            const matchKeyword = c.nama.toLowerCase().includes(keyword) || c.industri.toLowerCase().includes(keyword);
            const matchKategori = kategori === 'semua' || c.kategori === kategori;
            return matchKeyword && matchKategori;
        });

        emptyState.classList.toggle('hidden', filtered.length > 0);

        clientList.innerHTML = filtered.map(c => {
            const k = kategoriLabel[c.kategori];
            return `
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-xl font-bold">${c.avatar}</div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${k.color}">${k.label}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">${c.nama}</h3>
                    <p class="text-green-600 text-sm font-medium mb-3">${c.industri}</p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ${c.proyek} Proyek
                        </span>
                        <span class="inline-flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Terpercaya
                        </span>
                    </div>
                    <button class="w-full py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">Hubungi Client</button>
                </div>
            `;
        }).join('');
    }

    searchInput.addEventListener('input', renderClients);
    filterSelect.addEventListener('change', renderClients);
    renderClients();
</script>
@endsection
@endsection
