@extends('layouts.app')

@section('title', 'Kelola Mentor - EJSC Bakorwil')

@section('content')
<section class="bg-white border-b border-gray-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Mentor</h1>
                <p class="text-gray-600 mt-1">Tambahkan, edit, dan hapus data mentor</p>
            </div>
            <button id="btn-add" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Mentor
            </button>
        </div>
    </div>
</section>

<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modal Tambah/Edit -->
        <div id="modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/50" onclick="closeModal()"></div>
                <div class="relative bg-white rounded-2xl w-full max-w-lg shadow-2xl p-8 my-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="modal-title" class="text-xl font-bold text-gray-900">Tambah Mentor</h2>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <form id="mentor-form" class="space-y-4">
                        <input type="hidden" id="edit-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input id="input-nama" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                            <select id="input-bidang" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="teknologi">Teknologi</option>
                                <option value="bisnis">Bisnis</option>
                                <option value="desain">Desain</option>
                                <option value="pendidikan">Pendidikan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                            <input id="input-keahlian" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman</label>
                            <input id="input-pengalaman" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">Simpan</button>
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
                <input id="search-input" type="text" placeholder="Cari mentor..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-white">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Mentor</th>
                            <th class="px-6 py-4">Bidang</th>
                            <th class="px-6 py-4">Keahlian</th>
                            <th class="px-6 py-4">Pengalaman</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mentor-table" class="divide-y divide-gray-100">
                    </tbody>
                </table>
            </div>
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <p class="text-gray-500">Mentor tidak ditemukan</p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    const bidangLabel = {
        teknologi: { label: 'Teknologi', color: 'bg-blue-100 text-blue-700' },
        bisnis: { label: 'Bisnis', color: 'bg-green-100 text-green-700' },
        desain: { label: 'Desain', color: 'bg-purple-100 text-purple-700' },
        pendidikan: { label: 'Pendidikan', color: 'bg-yellow-100 text-yellow-700' },
    };

    let mentors = [
        { id: 1, nama: 'Dr. Andi Wijaya', bidang: 'teknologi', keahlian: 'AI & Machine Learning', pengalaman: '15 tahun', avatar: 'AW' },
        { id: 2, nama: 'Rina Kusuma, MBA', bidang: 'bisnis', keahlian: 'Strategi Bisnis', pengalaman: '12 tahun', avatar: 'RK' },
        { id: 3, nama: 'Budi Santoso', bidang: 'teknologi', keahlian: 'Software Engineering', pengalaman: '10 tahun', avatar: 'BS' },
        { id: 4, nama: 'Siti Rahayu', bidang: 'desain', keahlian: 'UI/UX Design', pengalaman: '8 tahun', avatar: 'SR' },
        { id: 5, nama: 'Prof. Joko Susilo', bidang: 'pendidikan', keahlian: 'Metodologi Pengajaran', pengalaman: '20 tahun', avatar: 'JS' },
    ];
    let nextId = 6;

    const searchInput = document.getElementById('search-input');
    const tableBody = document.getElementById('mentor-table');
    const emptyState = document.getElementById('empty-state');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const form = document.getElementById('mentor-form');
    const editId = document.getElementById('edit-id');

    function renderTable() {
        const keyword = searchInput.value.toLowerCase();
        const filtered = mentors.filter(m => m.nama.toLowerCase().includes(keyword));

        emptyState.classList.toggle('hidden', filtered.length > 0);

        tableBody.innerHTML = filtered.map(m => {
            const b = bidangLabel[m.bidang];
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">${m.avatar}</div>
                            <span class="font-medium text-gray-900">${m.nama}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-medium ${b.color}">${b.label}</span></td>
                    <td class="px-6 py-4 text-gray-600">${m.keahlian}</td>
                    <td class="px-6 py-4 text-gray-600">${m.pengalaman}</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <button onclick='editMentor(${m.id})' class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button onclick='deleteMentor(${m.id})' class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        if (filtered.length === 0) {
            tableBody.innerHTML = '';
        }
    }

    function openModal(isEdit = false) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        modalTitle.textContent = isEdit ? 'Edit Mentor' : 'Tambah Mentor';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        form.reset();
        editId.value = '';
    }

    function editMentor(id) {
        const m = mentors.find(x => x.id === id);
        if (!m) return;
        editId.value = m.id;
        document.getElementById('input-nama').value = m.nama;
        document.getElementById('input-bidang').value = m.bidang;
        document.getElementById('input-keahlian').value = m.keahlian;
        document.getElementById('input-pengalaman').value = m.pengalaman;
        openModal(true);
    }

    function deleteMentor(id) {
        if (confirm('Yakin ingin menghapus mentor ini?')) {
            mentors = mentors.filter(m => m.id !== id);
            renderTable();
        }
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nama = document.getElementById('input-nama').value;
        const bidang = document.getElementById('input-bidang').value;
        const keahlian = document.getElementById('input-keahlian').value;
        const pengalaman = document.getElementById('input-pengalaman').value;
        const id = editId.value;

        if (id) {
            const idx = mentors.findIndex(m => m.id === parseInt(id));
            mentors[idx] = { ...mentors[idx], nama, bidang, keahlian, pengalaman };
        } else {
            mentors.push({
                id: nextId++,
                nama,
                bidang,
                keahlian,
                pengalaman,
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
