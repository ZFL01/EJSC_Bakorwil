@extends('layouts.admin')

@section('title', 'Kelola Talenta')
@section('header', 'Kelola Talenta')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-4 rounded-xl border border-gray-200">
        <form action="{{ route('admin.talents.index') }}" method="GET" class="flex flex-wrap gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau skill..." 
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
            <select name="status_pekerjaan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                <option value="">-- Semua Status --</option>
                <option value="bekerja" {{ request('status_pekerjaan') === 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                <option value="belum bekerja" {{ request('status_pekerjaan') === 'belum bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                <option value="magang" {{ request('status_pekerjaan') === 'magang' ? 'selected' : '' }}>Magang</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">Filter</button>
        </form>
        <a href="{{ route('admin.talents.create') }}" class="bg-[#56b8c2] hover:bg-[#3d9aa3] text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
            + Tambah Talent
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Keahlian</th>
                        <th class="p-4">Skill Tags</th>
                        <th class="p-4">Mentor</th>
                        <th class="p-4">Status Kerja</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($talents as $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-800">{{ $t->nama }}</td>
                            <td class="p-4 text-gray-600">{{ $t->keahlian }}</td>
                            <td class="p-4">
                                @if($t->skill_tags)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($t->skill_tags as $tag)
                                            <span class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded-full">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-600">{{ $t->mentor->nama ?? '-' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $t->status_pekerjaan === 'bekerja' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $t->status_pekerjaan === 'belum bekerja' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $t->status_pekerjaan === 'magang' ? 'bg-sky-100 text-sky-700' : '' }}">
                                    {{ ucfirst($t->status_pekerjaan ?? '-') }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.talents.show', $t->id_talenta) }}" class="text-sky-600 hover:underline font-medium">Detail</a>
                                <a href="{{ route('admin.talents.edit', $t->id_talenta) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                                <form action="{{ route('admin.talents.destroy', $t->id_talenta) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus talent ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Data Talent belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($talents->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $talents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
