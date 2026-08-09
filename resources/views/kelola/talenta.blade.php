@extends('layouts.app')

@section('title', 'Kelola Talenta - EJSC Bakorwil')

@section('content')
<section class="bg-white border-b border-gray-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Talenta</h1>
                <p class="text-gray-600 mt-1">Tambahkan, edit, dan hapus data talenta</p>
            </div>
            <button id="btn-add" class="inline-flex items-center px-6 py-2.5 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Talenta
            </button>
        </div>
    </div>
</section>

<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modal -->
        <div id="modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/50" onclick="closeModal()"></div>
                <div class="relative bg-white rounded-2xl w-full max-w-lg shadow-2xl p-8 my-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="modal-title" class="text-xl font-bold text-gray-900">Tambah Talenta</h2>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <form id="talenta-form" class="space-y-4">
                        <input type="hidden" id="edit-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input id="input-nama" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                            <select id="input-keahlian" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="programming">Programming</option>
                                <option value="design">Design</option>
                                <option value="marketing">Marketing</option>
                                <option value="data">Data Analysis</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skill</label>
                            <input id="input-skill" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                            <select id="input-level" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="Senior">Senior</option>
                                <option value="Mid">Mid</option>
                                <option value="Junior">Junior</option>
                            </select>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 py-2.5 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">Simpan</button>
                            <button type="button" onclick="closeModal()" class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative md:w-80">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="search-input" type="text" placeholder="Cari talenta..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Talenta</th>
                            <th class="px-6 py-4">Keahlian</th>
                            <th class="px-6 py-4">Skill</th>
                            <th class="px-6 py-4">Level</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="talenta-table" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <p class="text-gray-500">Talenta tidak ditemukan</p>
        </div>
    </div>
</section>

@section('scripts')
<script>
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

    let talentas = [
        { id: 1, nama: 'Ahmad Fauzi', keahlian: 'programming', skill: 'Full Stack Developer', level: 'Senior', avatar: 'AF' },
        { id: 2, nama: 'Putri Maharani', keahlian: 'design', skill: 'UI Designer', level: 'Senior', avatar: 'PM' },
        { id: 3, nama: 'Rizky Ramadhan', keahlian: 'programming', skill: 'Backend Engineer', level: 'Mid', avatar: 'RR' },
        { id: 4, nama: 'Dewi Lestari', keahlian: 'marketing', skill: 'Digital Marketing', level: 'Senior', avatar: 'DL' },
        { id: 5, nama: 'Fajar Nugroho', keahlian: 'data', skill: 'Data Scientist', level: 'Senior', avatar: 'FN' },
    ];
    let nextId = 6;

    const searchInput = document.getElementById('search-input');
    const tableBody = document.getElementById('talenta-table');
    const emptyState = document.getElementById('empty-state');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const form = document.getElementById('talenta-form');
    const editId = document.getElementById('edit-id');

    function renderTable() {
        const keyword = searchInput.value.toLowerCase();
        const filtered = talentas.filter(t => t.nama.toLowerCase().includes(keyword));
        emptyState.classList.toggle('hidden', filtered.length > 0);

        tableBody.innerHTML = filtered.map(t => {
            const k = keahlianLabel[t.keahlian];
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">${t.avatar}</div>
                            <span class="font-medium text-gray-900">${t.nama}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-medium ${k.color}">${k.label}</span></td>
                    <td class="px-6 py-4 text-gray-600">${t.skill}</td>
                    <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-medium ${levelColor[t.level]}">${t.level}</span></td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <button onclick='editTalenta(${t.id})' class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button onclick='deleteTalenta(${t.id})' class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        if (filtered.length === 0) tableBody.innerHTML = '';
    }

    function openModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        modalTitle.textContent = isEdit ? 'Edit Talenta' : 'Tambah Talenta';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        form.reset();
        editId.value = '';
    }

    function editTalenta(id) {
        const t = talentas.find(x => x.id === id);
        if (!t) return;
        editId.value = t.id;
        document.getElementById('input-nama').value = t.nama;
        document.getElementById('input-keahlian').value = t.keahlian;
        document.getElementById('input-skill').value = t.skill;
        document.getElementById('input-level').value = t.level;
        openModal(true);
    }

    function deleteTalenta(id) {
        if (confirm('Yakin ingin menghapus talenta ini?')) {
            talentas = talentas.filter(t => t.id !== id);
            renderTable();
        }
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nama = document.getElementById('input-nama').value;
        const keahlian = document.getElementById('input-keahlian').value;
        const skill = document.getElementById('input-skill').value;
        const level = document.getElementById('input-level').value;
        const id = editId.value;

        if (id) {
            const idx = talentas.findIndex(t => t.id === parseInt(id));
            talentas[idx] = { ...talentas[idx], nama, keahlian, skill, level };
        } else {
            talentas.push({
                id: nextId++,
                nama,
                keahlian,
                skill,
                level,
                avatar: nama.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase()
            });
        }
        closeModal();
        renderTable();
    });

    document.getElementById('btn-add').addEventListener('click', () => openModal(false));
    searchInput.addEventListener('input', renderTable);
    renderTable();
</script>
@endsection
@endsection
