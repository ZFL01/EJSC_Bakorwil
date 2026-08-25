@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')
@section('header', 'Kelola Kegiatan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-4 rounded-xl border border-gray-200">
        <form action="{{ route('admin.kegiatans.index') }}" method="GET" class="flex flex-wrap gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan..." 
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                <option value="">-- Semua Status --</option>
                <option value="akan_datang" {{ request('status') === 'akan_datang' ? 'selected' : '' }}>Akan Datang</option>
                <option value="berlangsung" {{ request('status') === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">Filter</button>
        </form>
        <a href="{{ route('admin.kegiatans.create') }}" class="bg-[#56b8c2] hover:bg-[#3d9aa3] text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
            + Tambah Kegiatan
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama Kegiatan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Kuota</th>
                        <th class="p-4">Publik</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kegiatans as $k)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-800">{{ $k->judul_kegiatan }}</td>
                            <td class="p-4 text-gray-600">{{ $k->tanggal_kegiatan?->format('d M Y') ?? '-' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $k->status === 'akan_datang' ? 'bg-sky-100 text-sky-700' : '' }}
                                    {{ $k->status === 'berlangsung' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $k->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $k->status === 'dibatalkan' ? 'bg-rose-100 text-rose-700' : '' }}
                                    {{ !in_array($k->status, ['akan_datang', 'berlangsung', 'selesai', 'dibatalkan']) ? 'bg-gray-100 text-gray-600' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $k->status ?? '-')) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600">{{ $k->lokasi ?? '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $k->max_participants ?? '∞' }}</td>
                            <td class="p-4">
                                @if($k->is_public)
                                    <span class="text-emerald-500">✓</span>
                                @else
                                    <span class="text-gray-400">✕</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.kegiatans.participants', $k->id_kegiatan) }}" class="text-purple-600 hover:underline font-medium" title="Manage Participants">Peserta</a>
                                <a href="{{ route('admin.kegiatans.show', $k->id_kegiatan) }}" class="text-sky-600 hover:underline font-medium">Detail</a>
                                <a href="{{ route('admin.kegiatans.edit', $k->id_kegiatan) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                                <form action="{{ route('admin.kegiatans.destroy', $k->id_kegiatan) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">Data Kegiatan belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kegiatans->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $kegiatans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
