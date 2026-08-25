@extends('layouts.admin')

@section('title', 'Kelola Client')
@section('header', 'Kelola Client (UMKM)')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-4 rounded-xl border border-gray-200">
        <form action="{{ route('admin.clients.index') }}" method="GET" class="flex flex-wrap gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari UMKM atau Produk..." 
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                <option value="">-- Semua Status --</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak aktif" {{ request('status') === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">Filter</button>
        </form>
        <a href="{{ route('admin.clients.create') }}" class="bg-[#56b8c2] hover:bg-[#3d9aa3] text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
            + Tambah Client Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama UKM</th>
                        <th class="p-4">Jenis Produk</th>
                        <th class="p-4">Kontak (WA)</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($clients as $c)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-800">{{ $c->nama_ukm }}</td>
                            <td class="p-4 text-gray-600">{{ $c->nama_produk }}</td>
                            <td class="p-4 text-gray-600">{{ $c->no_hp }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $c->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.clients.show', $c->id_client) }}" class="text-sky-600 hover:underline font-medium">Detail</a>
                                <a href="{{ route('admin.clients.edit', $c->id_client) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                                <form action="{{ route('admin.clients.destroy', $c->id_client) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data client ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400">Data Client belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($clients->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
