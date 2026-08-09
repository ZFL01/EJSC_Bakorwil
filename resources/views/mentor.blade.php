@extends('layouts.app')

@section('title', 'Menu Mentor - EJSC Bakorwil')

@section('content')
<section class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Daftar Mentor</h1>
        <p class="text-lg text-indigo-100">Temukan mentor berpengalaman untuk membimbing pengembangan karier Anda</p>
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
                    <input id="search-input" type="text" placeholder="Cari mentor..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                </div>
                <div class="flex items-center gap-3">
                    <select id="filter-select" class="px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500">
                        <option value="semua">Semua Bidang</option>
                        <option value="teknologi">Teknologi</option>
                        <option value="bisnis">Bisnis</option>
                        <option value="desain">Desain</option>
                        <option value="pendidikan">Pendidikan</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="mentor-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Mentor cards will be rendered by JS -->
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Mentor tidak ditemukan</h3>
            <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter bidang</p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    const mentors = [
        { nama: 'Dr. Andi Wijaya', bidang: 'teknologi', keahlian: 'AI & Machine Learning', pengalaman: '15 tahun', avatar: 'AW' },
        { nama: 'Rina Kusuma, MBA', bidang: 'bisnis', keahlian: 'Strategi Bisnis', pengalaman: '12 tahun', avatar: 'RK' },
        { nama: 'Budi Santoso', bidang: 'teknologi', keahlian: 'Software Engineering', pengalaman: '10 tahun', avatar: 'BS' },
        { nama: 'Siti Rahayu', bidang: 'desain', keahlian: 'UI/UX Design', pengalaman: '8 tahun', avatar: 'SR' },
        { nama: 'Prof. Joko Susilo', bidang: 'pendidikan', keahlian: 'Metodologi Pengajaran', pengalaman: '20 tahun', avatar: 'JS' },
        { nama: 'Maya Anggraini', bidang: 'bisnis', keahlian: 'Marketing & Branding', pengalaman: '9 tahun', avatar: 'MA' },
        { nama: 'David Pratama', bidang: 'teknologi', keahlian: 'Cloud & DevOps', pengalaman: '11 tahun', avatar: 'DP' },
        { nama: 'Lestari Dewi', bidang: 'desain', keahlian: 'Motion & Animation', pengalaman: '7 tahun', avatar: 'LD' },
        { nama: 'Hendra Gunawan', bidang: 'pendidikan', keahlian: 'Kurikulum & Training', pengalaman: '13 tahun', avatar: 'HG' },
    ];

    const bidangLabel = {
        teknologi: { label: 'Teknologi', color: 'bg-blue-100 text-blue-700' },
        bisnis: { label: 'Bisnis', color: 'bg-green-100 text-green-700' },
        desain: { label: 'Desain', color: 'bg-purple-100 text-purple-700' },
        pendidikan: { label: 'Pendidikan', color: 'bg-yellow-100 text-yellow-700' },
    };

    const searchInput = document.getElementById('search-input');
    const filterSelect = document.getElementById('filter-select');
    const mentorList = document.getElementById('mentor-list');
    const emptyState = document.getElementById('empty-state');

    function renderMentors() {
        const keyword = searchInput.value.toLowerCase();
        const bidang = filterSelect.value;

        const filtered = mentors.filter(m => {
            const matchKeyword = m.nama.toLowerCase().includes(keyword) || m.keahlian.toLowerCase().includes(keyword);
            const matchBidang = bidang === 'semua' || m.bidang === bidang;
            return matchKeyword && matchBidang;
        });

        emptyState.classList.toggle('hidden', filtered.length > 0);

        mentorList.innerHTML = filtered.map(m => {
            const b = bidangLabel[m.bidang];
            return `
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-xl font-bold">${m.avatar}</div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${b.color}">${b.label}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">${m.nama}</h3>
                    <p class="text-indigo-600 text-sm font-medium mb-3">${m.keahlian}</p>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pengalaman ${m.pengalaman}
                    </div>
                    <button class="w-full py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">Lihat Profil</button>
                </div>
            `;
        }).join('');
    }

    searchInput.addEventListener('input', renderMentors);
    filterSelect.addEventListener('change', renderMentors);
    renderMentors();
</script>
@endsection
