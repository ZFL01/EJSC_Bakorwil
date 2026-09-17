@extends('layouts.admin')

@section('title', 'Project')
@section('header', 'Kelola Project')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Daftar Project</h2>
            <p class="text-xs text-gray-500">Project memwadah kegiatan per OPD/bidang - dipakai oleh Ekspor Excel dan Peta GIS.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">+ Tambah Project</a>
    </div>

    <!-- Filter -->
    <form method="GET" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row gap-3 md:items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama project / OPD / bidang..."
               class="flex-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#56b8c2]">
        <select name="tahun" class="border border-gray-300 rounded-lg p-2 text-sm">
            <option value="">Semua Tahun</option>
            @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>
        <select name="status" class="border border-gray-300 rounded-lg p-2 text-sm">
            <option value="">Semua Status</option>
            @foreach(['draft', 'berjalan', 'selesai', 'dibatalkan'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-sm font-medium transition">Filter</button>
    </form>

    <!-- Tabel -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="p-3">Project</th>
                        <th class="p-3 w-20">Tahun</th>
                        <th class="p-3 w-20 text-center">Mentor</th>
                        <th class="p-3 w-20 text-center">Talenta</th>
                        <th class="p-3 w-20 text-center">Klien</th>
                        <th class="p-3 w-24">Status</th>
                        <th class="p-3 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3">
                                <a href="{{ route('admin.projects.show', $project->id_project) }}" class="font-semibold text-gray-800 hover:text-[#56b8c2]">{{ $project->nama_project }}</a>
                                <p class="text-xs text-gray-400">{{ $project->opd }}@if($project->bidang) / {{ $project->bidang }}@endif</p>
                            </td>
                            <td class="p-3 font-medium text-gray-700">{{ $project->tahun }}</td>
                            <td class="p-3 text-center">{{ $project->mentors_count }}</td>
                            <td class="p-3 text-center">{{ $project->talents_count }}</td>
                            <td class="p-3 text-center">{{ $project->clients_count }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $project->status === 'berjalan' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $project->status === 'selesai' ? 'bg-slate-100 text-slate-600' : '' }}
                                    {{ $project->status === 'draft' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $project->status === 'dibatalkan' ? 'bg-rose-100 text-rose-700' : '' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.projects.show', $project->id_project) }}" class="text-sky-600 hover:text-sky-800 text-xs font-medium">Detail</a>
                                    <a href="{{ route('admin.projects.edit', $project->id_project) }}" class="text-amber-600 hover:text-amber-800 text-xs font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $project->id_project) }}" onsubmit="return confirm('Hapus project ini beserta seluruh tautan anggotanya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-8 text-center text-gray-400">Belum ada project.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $projects->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
