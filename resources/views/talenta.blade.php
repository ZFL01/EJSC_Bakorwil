@extends('layouts.app')

@section('title', 'Daftar Talenta - EJSC Bakorwil')

@section('content')
<section class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Daftar Talenta</h1>
        <p class="text-lg text-purple-100">Jelajahi talenta terbaik dengan keahlian dan potensi luar biasa</p>
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
                    <input id="search-input" type="text" placeholder="Cari talenta..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white">
                </div>
                <div class="flex items-center gap-3">
                    <select id="filter-select" class="px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-purple-500">
                        <option value="semua">Semua Keahlian</option>
                        <option value="programming">Programming</option>
                        <option value="design">Design</option>
                        <option value="marketing">Marketing</option>
                        <option value="data">Data Analysis</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="talenta-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Talenta cards rendered by JS -->
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Talenta tidak ditemukan</h3>
            <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter keahlian</p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    const talentas = [
        { nama: 'Ahmad Fauzi', keahlian: 'programming', skill: 'Full Stack Developer', level: 'Senior', avatar: 'AF' },
        { nama: 'Putri Maharani', keahlian: 'design', skill: 'UI Designer', level: 'Senior', avatar: 'PM' },
        { nama: 'Rizky Ramadhan', keahlian: 'programming', skill: 'Backend Engineer', level: 'Mid', avatar: 'RR' },
        { nama: 'Dewi Lestari', keahlian: 'marketing', skill: 'Digital Marketing', level: 'Senior', avatar: 'DL' },
        { nama: 'Fajar Nugroho', keahlian: 'data', skill: 'Data Scientist', level: 'Senior', avatar: 'FN' },
        { nama: 'Intan Permata', keahlian: 'design', skill: 'UX Researcher', level: 'Mid', avatar: 'IP' },
        { nama: 'Bagas Prakoso', keahlian: 'programming', skill: 'Mobile Developer', level: 'Mid', avatar: 'BP' },
        { nama: 'Salsa Rahmadani', keahlian: 'marketing', skill: 'Content Creator', level: 'Junior', avatar: 'SR' },
        { nama: 'Yoga Saputra', keahlian: 'data', skill: 'Data Analyst', level: 'Mid', avatar: 'YS' },
    ];

    const keahlianLabel = {
        programming: { label: 'Programming', color: 'bg-blue-100 text-blue-700' },
        design: { label: 'Design', color: 'bg-purple-100 text-purple-700' },
        marketing: { label: 'Marketing', color: 'bg-green-100 text-green-700' },
        data: { label: 'Data Analysis', color: 'bg-yellow-100 text-yellow-700' },
    };

    const levelColor = {
        Senior: 'bg-red-100 text-red-700',
        Mid: 'bg-orange-100 text-orange-700',
        Junior: 'bg-green-100 text-green-700',
    };

    const searchInput = document.getElementById('search-input');
    const filterSelect = document.getElementById('filter-select');
    const talentaList = document.getElementById('talenta-list');
    const emptyState = document.getElementById('empty-state');

    function renderTalentas() {
        const keyword = searchInput.value.toLowerCase();
        const keahlian = filterSelect.value;

        const filtered = talentas.filter(t => {
            const matchKeyword = t.nama.toLowerCase().includes(keyword) || t.skill.toLowerCase().includes(keyword);
            const matchKeahlian = keahlian === 'semua' || t.keahlian === keahlian;
            return matchKeyword && matchKeahlian;
        });

        emptyState.classList.toggle('hidden', filtered.length > 0);

        talentaList.innerHTML = filtered.map(t => {
            const k = keahlianLabel[t.keahlian];
            return `
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center text-white text-xl font-bold">${t.avatar}</div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${levelColor[t.level]}">${t.level}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">${t.nama}</h3>
                    <p class="text-purple-600 text-sm font-medium mb-3">${t.skill}</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium ${k.color} mb-4">${k.label}</span>
                    <button class="w-full mt-2 py-2.5 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition">Lihat Profil</button>
                </div>
            `;
        }).join('');
    }

    searchInput.addEventListener('input', renderTalentas);
    filterSelect.addEventListener('change', renderTalentas);
    renderTalentas();
</script>
@endsection
@endsection
