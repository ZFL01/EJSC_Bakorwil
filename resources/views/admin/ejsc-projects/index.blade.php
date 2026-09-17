@extends('layouts.admin')

@section('title', 'Projek Kami')
@section('header', 'Kelola Projek Kami')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Projek Kami EJSC</h2>
            <p class="text-xs text-gray-500">Konten khusus untuk ditampilkan pada halaman Tentang Kami.</p>
        </div>
        <a href="{{ route('admin.ejsc-projects.create') }}" class="px-4 py-2 bg-[#56b8c2] hover:bg-[#3d9aa3] text-white rounded-lg text-sm font-medium transition">+ Tambah Projek</a>
    </div>

    <form method="GET" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul projek..." class="flex-1 border border-gray-300 rounded-lg p-2 text-sm">
        <select name="status" class="border border-gray-300 rounded-lg p-2 text-sm">
            <option value="">Semua Status</option>
            @foreach(['rencana', 'berjalan', 'selesai'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-sm font-medium">Filter</button>
    </form>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                    <tr><th class="p-3">Judul</th><th class="p-3">Tahun</th><th class="p-3">Status</th><th class="p-3">Publik</th><th class="p-3">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3"><div class="font-semibold text-gray-800">{{ $project->judul }}</div><div class="text-xs text-gray-400">{{ $project->ringkasan }}</div><div class="text-xs text-gray-400 mt-1">{{ count($project->talenta ?? []) }} talenta · {{ count($project->mentor ?? []) }} mentor · {{ count($project->tenaga_ahli ?? []) }} tenaga ahli</div></td>
                            <td class="p-3">{{ $project->tahun ?? '-' }}</td>
                            <td class="p-3"><span class="px-2 py-1 rounded-full text-xs font-semibold {{ $project->status === 'berjalan' ? 'bg-emerald-100 text-emerald-700' : ($project->status === 'selesai' ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($project->status) }}</span></td>
                            <td class="p-3">{{ $project->is_published ? 'Ya' : 'Tidak' }}</td>
                            <td class="p-3"><div class="flex items-center gap-3"><a href="{{ route('admin.ejsc-projects.show', $project) }}" class="text-sky-600 text-xs font-medium">Detail</a><a href="{{ route('admin.ejsc-projects.edit', $project) }}" class="text-amber-600 text-xs font-medium">Edit</a><form method="POST" action="{{ route('admin.ejsc-projects.destroy', $project) }}" onsubmit="return confirm('Hapus projek ini?')">@csrf @method('DELETE')<button class="text-rose-600 text-xs font-medium">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada projek khusus EJSC.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())<div class="p-4 border-t border-gray-100">{{ $projects->appends(request()->query())->links() }}</div>@endif
    </div>
</div>
@endsection
