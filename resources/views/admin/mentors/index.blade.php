@extends('layouts.admin')

@section('title', 'Kelola Mentor')
@section('header', 'Kelola Mentor')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-4 rounded-xl border border-gray-200">
        <form action="{{ route('admin.mentors.index') }}" method="GET" class="flex flex-wrap gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau keahlian..." 
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
            <select name="is_available" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                <option value="">-- Semua Status --</option>
                <option value="1" {{ request('is_available') === '1' ? 'selected' : '' }}>Available</option>
                <option value="0" {{ request('is_available') === '0' ? 'selected' : '' }}>Unavailable</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">Filter</button>
        </form>
        <a href="{{ route('admin.mentors.create') }}" class="bg-[#56b8c2] hover:bg-[#3d9aa3] text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
            + Tambah Mentor
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Keahlian</th>
                        <th class="p-4">Expertise Tags</th>
                        <th class="p-4">Jumlah Mentee</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mentors as $m)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-800">{{ $m->nama }}</td>
                            <td class="p-4 text-gray-600">{{ $m->keahlian }}</td>
                            <td class="p-4">
                                @if($m->expertise_tags)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($m->expertise_tags as $tag)
                                            <span class="px-2 py-0.5 bg-sky-50 text-sky-700 text-xs rounded-full">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-center text-gray-600 font-medium">{{ $m->jumlah_mentee }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $m->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $m->is_available ? 'Available' : 'Full' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.mentors.show', $m->id_mentor) }}" class="text-sky-600 hover:underline font-medium">Detail</a>
                                <a href="{{ route('admin.mentors.edit', $m->id_mentor) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                                <form action="{{ route('admin.mentors.destroy', $m->id_mentor) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus mentor ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Data Mentor belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mentors->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $mentors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
