@extends('layouts.app')

@section('title', 'Kelola Client - EJSC Bakorwil')

@section('content')
<section class="bg-white border-b border-gray-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Client</h1>
                <p class="text-gray-600 mt-1">Tambahkan, edit, dan hapus data client</p>
            </div>
            <button id="btn-add" class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Client
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
                        <h2 id="modal-title" class="text-xl font-bold text-gray-900">Tambah Client</h2>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <form id="client-form" class="space-y-4">
                        <input type="hidden" id="edit-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                            <input id="input-nama" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="input-kategori" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="korporasi">Korporasi</option>
                                <option value="startup">Startup</option>
                                <option value="umkm">UMKM</option>
                                <option value="pemerintahan">Pemerintahan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Industri</label>
                            <input id="input-industri" type="text" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Proyek</label>
                            <input id="input-proyek" type="number" min="0" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">Simpan</button>
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
                <input id="search-input" type="text" placeholder="Cari client..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 bg-white">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Industri</th>
                            <th class="px-6 py-4">Proyek</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="client-table" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <p class="text-gray-500">Client tidak ditemukan</p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    const kategoriLabel = {
        korporasi: { label: 'Korporasi', color: 'bg-blue-100 text-blue-700' },
        startup: { label: 'Startup', color: 'bg-purple-100 text-purple-700' },
        umkm: { label: 'UMKM', color: 'bg-green-100 text-green-700' },
        pemerintahan: { label: 'Pemerintahan', color: 'bg-yellow-100 text-yellow-700' },
    };

    let clients = [
        { id: 1, nama: 'PT Maju Bersama', kategori: 'korporasi', industri: 'Manufaktur', proyek: 25, avatar: 'MB' },
        { id: 2, nama: 'Startup Inovasi', kategori: 'startup', industri: 'Teknologi', proyek: 12, avatar: 'SI' },
        { id: 3, nama: 'CV Karya Mandiri', kategori: 'umkm', industri: 'Kuliner', proyek: 8, avatar: 'KM' },
        { id: 4, nama: 'Dinas Pendidikan', kategori: 'pemerintahan', industri: 'Pendidikan', proyek: 15, avatar: 'DP' },
        { id: 5, nama: 'PT Solusi Digital', kategori: 'korporasi', industri: 'IT Services', proyek: 30, avatar: 'SD' },
    ];
    let nextId = 6;

    const searchInput = document.getElementById('search-input');
    const tableBody = document.getElementById('client-table');
    const emptyState = document.getElementById('empty-state');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const form = document.getElementById('client-form');
    const editId = document.getElementById('edit-id');

    function renderTable() {
        const keyword = searchInput.value.toLowerCase();
        const filtered = clients.filter(c => c.nama.toLowerCase().includes(keyword));
        emptyState.classList.toggle('hidden', filtered.length > 0);

        tableBody.innerHTML = filtered.map(c => {
            const k = kategoriLabel[c.kategori];
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">${c.avatar}</div>
                            <span class="font-medium text-gray-900">${c.nama}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-medium ${k.color}">${k.label}</span></td>
                    <td class="px-6 py-4 text-gray-600">${c.industri}</td>
                    <td class="px-6 py-4 text-gray-600">${c.proyek} Proyek</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2">
                            <button onclick='editClient(${c.id})' class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button onclick='deleteClient(${c.id})' class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
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
        modalTitle.textContent = isEdit ? 'Edit Client' : 'Tambah Client';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        form.reset();
        editId.value = '';
    }

    function editClient(id) {
        const c = clients.find(x => x.id === id);
        if (!c) return;
        editId.value = c.id;
        document.getElementById('input-nama').value = c.nama;
        document.getElementById('input-kategori').value = c.kategori;
        document.getElementById('input-industri').value = c.industri;
        document.getElementById('input-proyek').value = c.proyek;
        openModal(true);
    }

    function deleteClient(id) {
        if (confirm('Yakin ingin menghapus client ini?')) {
            clients = clients.filter(c => c.id !== id);
            renderTable();
        }
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nama = document.getElementById('input-nama').value;
        const kategori = document.getElementById('input-kategori').value;
        const industri = document.getElementById('input-industri').value;
        const proyek = document.getElementById('input-proyek').value;
        const id = editId.value;

        if (id) {
            const idx = clients.findIndex(c => c.id === parseInt(id));
            clients[idx] = { ...clients[idx], nama, kategori, industri, proyek: parseInt(proyek) };
        } else {
            clients.push({
                id: nextId++,
                nama,
                kategori,
                industri,
                proyek: parseInt(proyek),
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
