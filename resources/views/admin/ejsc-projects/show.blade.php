@extends('layouts.admin')

@section('title', 'Detail Projek Kami')
@section('header', 'Detail Projek Kami')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
    @endif

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div class="flex gap-4">
            <div>
                <div class="flex items-center gap-2"><h2 class="text-lg font-bold text-gray-800">{{ $ejscProject->judul }}</h2><span class="px-2 py-1 rounded-full text-xs bg-[#f0f9fa] text-[#2e8791]">{{ $ejscProject->tahun ?? '-' }}</span></div>
                <p class="text-sm text-gray-500 mt-1">{{ $ejscProject->ringkasan }}</p>
            </div>
        </div>
        <div class="flex gap-2"><a href="{{ route('admin.ejsc-projects.edit', $ejscProject) }}" class="px-4 py-2 bg-amber-50 text-amber-700 rounded-lg text-sm">Edit</a><a href="{{ route('admin.ejsc-projects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">Kembali</a></div>
    </div>

    @if($ejscProject->galeri)
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-3">Gambar Kegiatan ({{ count($ejscProject->galeri) }})</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($ejscProject->galeri as $imagePath)
                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Gambar kegiatan {{ $ejscProject->judul }}" class="h-32 w-full object-cover rounded-lg border">
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-3">Talenta Terlibat ({{ $ejscProject->talents->count() }})</h3>
            @forelse($ejscProject->talents as $talent)
                <div class="flex items-center justify-between py-2 border-b last:border-0 text-sm"><span>{{ $talent->nama }}<small class="block text-gray-400">{{ $talent->keahlian }}</small></span><form method="POST" action="{{ route('admin.ejsc-projects.detach', $ejscProject) }}">@csrf<input type="hidden" name="type" value="talenta"><input type="hidden" name="id" value="{{ $talent->id_talenta }}"><button class="text-rose-600 text-xs">Lepas</button></form></div>
            @empty <p class="text-sm text-gray-400">Belum ada talenta.</p>@endforelse
            @if($talentOptions->count())
                <form method="POST" action="{{ route('admin.ejsc-projects.attach', $ejscProject) }}" class="mt-4 flex gap-2">@csrf<input type="hidden" name="type" value="talenta"><select name="id" required class="min-w-0 flex-1 border rounded-lg p-2 text-sm"><option value="">Pilih talenta</option>@foreach($talentOptions as $talent)<option value="{{ $talent->id_talenta }}">{{ $talent->nama }}</option>@endforeach</select><button class="px-3 py-2 bg-purple-600 text-white rounded-lg text-xs">Tambah</button></form>
            @endif
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-3">Mentor Terlibat ({{ $ejscProject->mentors->count() }})</h3>
            @forelse($ejscProject->mentors as $mentor)
                <div class="flex items-center justify-between py-2 border-b last:border-0 text-sm"><span>{{ $mentor->nama }}<small class="block text-gray-400">{{ $mentor->keahlian }}</small></span><form method="POST" action="{{ route('admin.ejsc-projects.detach', $ejscProject) }}">@csrf<input type="hidden" name="type" value="mentor"><input type="hidden" name="id" value="{{ $mentor->id_mentor }}"><button class="text-rose-600 text-xs">Lepas</button></form></div>
            @empty <p class="text-sm text-gray-400">Belum ada mentor.</p>@endforelse
            @if($mentorOptions->count())
                <form method="POST" action="{{ route('admin.ejsc-projects.attach', $ejscProject) }}" class="mt-4 flex gap-2">@csrf<input type="hidden" name="type" value="mentor"><select name="id" required class="min-w-0 flex-1 border rounded-lg p-2 text-sm"><option value="">Pilih mentor</option>@foreach($mentorOptions as $mentor)<option value="{{ $mentor->id_mentor }}">{{ $mentor->nama }}</option>@endforeach</select><button class="px-3 py-2 bg-emerald-600 text-white rounded-lg text-xs">Tambah</button></form>
            @endif
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-3">Tenaga Ahli ({{ $ejscProject->experts->count() }})</h3>
            @forelse($ejscProject->experts as $expert)
                <div class="flex items-center justify-between py-2 border-b last:border-0 text-sm"><span>{{ $expert->nama }}<small class="block text-gray-400">{{ $expert->keahlian }}</small></span><form method="POST" action="{{ route('admin.ejsc-projects.detach', $ejscProject) }}">@csrf<input type="hidden" name="type" value="tenaga_ahli"><input type="hidden" name="id" value="{{ $expert->id }}"><button class="text-rose-600 text-xs">Lepas</button></form></div>
            @empty <p class="text-sm text-gray-400">Belum ada tenaga ahli.</p>@endforelse
            <form method="POST" action="{{ route('admin.ejsc-projects.attach', $ejscProject) }}" class="mt-4 space-y-2">@csrf<input type="hidden" name="type" value="tenaga_ahli"><input name="nama" required placeholder="Nama tenaga ahli" class="w-full border rounded-lg p-2 text-sm"><input name="keahlian" placeholder="Keahlian (opsional)" class="w-full border rounded-lg p-2 text-sm"><button class="w-full px-3 py-2 bg-sky-600 text-white rounded-lg text-xs">Tambah Tenaga Ahli</button></form>
        </div>
    </div>
</div>
@endsection
