"@extends('layouts.admin')

@section('title', 'Detail Kegiatan')
@section('header', 'Detail Kegiatan')

@section('content')
<div class="max-w-4xl bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h3>
            <p class="text-sm text-gray-500">Dibuat oleh: {{ $kegiatan->organizer->name ?? 'Admin' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                {{ $kegiatan->jenis_kegiatan === 'online' ? 'bg-sky-100 text-sky-700' : '' }}
                {{ $kegiatan->jenis_kegiatan === 'offline' ? 'bg-amber-100 text-amber-700' : '' }}
                {{ $kegiatan->jenis_kegiatan === 'hybrid' ? 'bg-purple-100 text-purple-700' : '' }}">
                {{ ucfirst($kegiatan->jenis_kegiatan) }}
            </span>
            <a href="{{ route('admin.kegiatans.edit', $kegiatan->id_kegiatan) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg transition">Edit</a>
            <a href="{{ route('admin.kegiatans.index') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Informasi Kegiatan</h4>
            <dl class="space-y-2 text-sm">
                <div>
                    <dt class="text-xs text-gray-400">Tanggal</dt>
                    <dd class="font-medium text-gray-800">{{ $kegiatan->tanggal ? Carbon::parse($kegiatan->tanggal)->format('d F Y') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Lokasi / Link</dt>
                    <dd class="text-gray-800">{{ $kegiatan->lokasi ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Kuota Maksimal</dt>
                    <dd class="font-medium text-gray-800">{{ $kegiatan->max_participants ?? 'Tidak terbatas' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400">Status Publik</dt>
                    <dd class="font-medium {{ $kegiatan->is_public ? 'text-emerald-600' : 'text-gray-500' }}">
                        {{ $kegiatan->is_public ? 'Tampil di Publik' : 'Hanya Internal' }}
                    </dd>
                </div>
                <div class="pt-2">
                    <dt class="text-xs text-gray-400 mb-1">Keterangan</dt>
                    <dd class="text-gray-800 bg-gray-50 p-3 rounded-lg border">{{ $kegiatan->keterangan ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Statistik Peserta</h4>
            <div class="grid grid-cols-2 gap-2">
                <div class="bg-gray-50 p-3 rounded-lg border text-center">
                    <p class="text-2xl font-bold text-[#56b8c2]">{{ $stats['registered'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Terdaftar</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg border text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ $stats['confirmed'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Dikonfirmasi</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg border text-center">
                    <p class="text-2xl font-bold text-sky-600">{{ $stats['attended'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Hadir</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg border text-center">
                    <p class="text-2xl font-bold text-rose-600">{{ $stats['cancelled'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Batal</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.kegiatans.participants', $kegiatan->id_kegiatan) }}" class="block w-full text-center bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-semibold py-3 rounded-lg border border-purple-200 transition">
                    Kelola Semua Peserta
                </a>
            </div>
        </div>
    </div>

    @if(isset($kegiatan->gallery) && count($kegiatan->gallery) > 0)
        <div class="border-t pt-4">
            <h4 class="text-sm font-bold text-gray-700 mb-2">Galeri Kegiatan</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($kegiatan->gallery as $image)
                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="block aspect-square bg-gray-100 rounded-lg overflow-hidden border hover:opacity-75 transition">
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery" class="w-full h-full object-cover">
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection"