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
        <th class="px-6 py-4 text-left w-[24%]">Nama Kegiatan</th>
        <th class="px-6 py-4 text-center w-[12%] whitespace-nowrap">Tanggal</th>
        <th class="px-6 py-4 text-center w-[12%] whitespace-nowrap">Status</th>
        <th class="px-6 py-4 text-left w-[22%]">Lokasi</th>
        <th class="px-6 py-4 text-center w-[8%] whitespace-nowrap">Kuota</th>
        <th class="px-6 py-4 text-center w-[7%] whitespace-nowrap">Publik</th>
        <th class="px-6 py-4 text-center w-[15%] whitespace-nowrap">Aksi</th>
    </tr>
</thead>

<tbody class="divide-y divide-gray-100">

    @forelse($kegiatans as $k)

        <tr class="hover:bg-gray-50 transition">

            {{-- Nama Kegiatan --}}
            <td class="px-6 py-6 align-middle">
                <div class="font-semibold text-gray-800 whitespace-nowrap">
                    {{ $k->judul_kegiatan }}
                </div>
            </td>

            {{-- Tanggal --}}
            <td class="px-6 py-6 text-center text-gray-600 align-middle whitespace-nowrap">
                {{ $k->tanggal_kegiatan?->format('d M Y') ?? '-' }}
            </td>

            {{-- Status --}}
            <td class="px-6 py-5 text-center align-middle">
                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                    {{ $k->status === 'akan_datang' ? 'bg-sky-100 text-sky-700' : '' }}
                    {{ $k->status === 'berlangsung' ? 'bg-amber-100 text-amber-700' : '' }}
                    {{ $k->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
                    {{ $k->status === 'dibatalkan' ? 'bg-rose-100 text-rose-700' : '' }}
                    {{ !in_array($k->status, ['akan_datang', 'berlangsung', 'selesai', 'dibatalkan']) ? 'bg-gray-100 text-gray-600' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $k->status ?? '-')) }}
                </span>
            </td>

            {{-- Lokasi --}}
            <td class="px-6 py-5 text-gray-600 align-middle">
                <div class="leading-6">
                    {{ $k->lokasi ?? '-' }}
                </div>
            </td>

            {{-- Kuota --}}
            <td class="px-6 py-5 text-center text-gray-600 align-middle whitespace-nowrap">
                {{ $k->max_participants ?? '∞' }}
            </td>

            {{-- Publik --}}
            <td class="px-6 py-5 text-center align-middle">
                @if($k->is_public)
                    <span class="text-emerald-500 text-lg font-bold">✓</span>
                @else
                    <span class="text-gray-400 text-lg">✕</span>
                @endif
            </td>

            {{-- Aksi --}}
            <td class="px-6 py-5 align-middle">
                <div class="flex items-center justify-center gap-4 whitespace-nowrap">
                    <a href="{{ route('admin.kegiatans.participants', $k->id_kegiatan) }}"
                       class="text-purple-600 hover:text-purple-800 hover:underline font-medium">
                        Peserta
                    </a>

                    <a href="{{ route('admin.kegiatans.show', $k->id_kegiatan) }}"
                       class="text-sky-600 hover:text-sky-800 hover:underline font-medium">
                        Detail
                    </a>

                    <a href="{{ route('admin.kegiatans.edit', $k->id_kegiatan) }}"
                       class="text-amber-600 hover:text-amber-800 hover:underline font-medium">
                        Edit
                    </a>

                    <form action="{{ route('admin.kegiatans.destroy', $k->id_kegiatan) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-rose-600 hover:text-rose-800 hover:underline font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                Data Kegiatan belum tersedia.
            </td>
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