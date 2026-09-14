@extends('layouts.app')

@section('title', 'Kegiatan - ' . ($kegiatan->judul_kegiatan ?? 'Detail'))

@php
    /* Locale aplikasi "en" - tanggal diformat manual agar berbahasa Indonesia */
    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $formatTanggal = function ($tanggal) use ($bulanIndo) {
        return $tanggal
            ? $tanggal->day . ' ' . $bulanIndo[(int) $tanggal->format('n')] . ' ' . $tanggal->year
            : '-';
    };

    $statusMap = [
        'akan_datang' => ['label' => 'Akan Datang', 'class' => 'bg-amber-100 text-amber-700'],
        'berlangsung' => ['label' => 'Berlangsung', 'class' => 'bg-emerald-100 text-emerald-700'],
        'selesai'     => ['label' => 'Selesai', 'class' => 'bg-slate-100 text-slate-600'],
        'dibatalkan'  => ['label' => 'Dibatalkan', 'class' => 'bg-rose-100 text-rose-700'],
    ];

    $st = $statusMap[$kegiatan->status]
        ?? ['label' => ucfirst((string) $kegiatan->status), 'class' => 'bg-slate-100 text-slate-600'];

    $participationLabel = [
        'registered' => 'Menunggu Konfirmasi Admin',
        'confirmed'  => 'Terkonfirmasi',
        'attended'   => 'Sudah Hadir',
        'cancelled'  => 'Dibatalkan',
    ];

    /* Kegiatan dianggap lewat bila tanggalnya sudah melewati hari ini */
    $isPast = $kegiatan->tanggal_kegiatan
        ? $kegiatan->tanggal_kegiatan->copy()->endOfDay()->isPast()
        : false;
@endphp

@section('content')

<div class="min-h-screen bg-[#f8feff] py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- BACK -->
        <a href="{{ route('public.kegiatans.index') }}" class="inline-flex items-center gap-2 mb-8 text-[#16b8c4] font-medium hover:text-[#159da8]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Kegiatan
        </a>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl border border-[#dceff2] overflow-hidden">

            <!-- HEADER -->
            <div class="p-8 md:p-10 bg-gradient-to-br from-[#dffbfc] via-white to-[#f3feff]">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $st['class'] }}">
                    {{ $st['label'] }}
                </span>

                <h1 class="mt-4 text-2xl md:text-3xl font-bold text-[#17384d]">
                    {{ $kegiatan->judul_kegiatan }}
                </h1>

                <div class="mt-6 grid sm:grid-cols-3 gap-4 text-sm text-[#3d6473]">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-[#14b8c4] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-[#17384d]">Tanggal</div>
                            {{ $formatTanggal($kegiatan->tanggal_kegiatan) }}
                        </div>
                    </div>

                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-[#14b8c4] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-[#17384d]">Lokasi</div>
                            {{ $kegiatan->lokasi ?? 'EJSC Bakorwil' }}
                        </div>
                    </div>

                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-[#14b8c4] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-[#17384d]">Penyelenggara</div>
                            {{ $kegiatan->organizer?->name ?? 'Admin EJSC' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-8 md:p-10 space-y-8">

                @if($kegiatan->deskripsi)
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#7da0ad] mb-2">Deskripsi</h2>
                        <p class="text-[#3d6473] leading-relaxed whitespace-pre-line">{{ $kegiatan->deskripsi }}</p>
                    </div>
                @endif

                <!-- KUOTA -->
                <div class="rounded-2xl border border-[#e3f6f8] bg-[#f8feff] p-4 text-sm text-[#3d6473]">
                    <span class="font-semibold text-[#17384d]">Peserta terdaftar:</span>
                    {{ $participantCount }}@if(!is_null($kegiatan->max_participants)) / {{ $kegiatan->max_participants }}@endif

                    @if(!is_null($kegiatan->max_participants))
                        @if($availableSlots)
                            <span class="ml-2 text-emerald-600 font-medium">&mdash; Masih tersedia</span>
                        @else
                            <span class="ml-2 text-rose-600 font-medium">&mdash; Kuota penuh</span>
                        @endif
                    @endif
                </div>

                <!-- GALERI -->
                @if(!empty($kegiatan->gallery))
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#7da0ad] mb-3">Galeri</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($kegiatan->gallery as $img)
                                <img src="{{ asset('storage/' . $img) }}" alt="Foto kegiatan"
                                     class="w-full h-40 object-cover rounded-xl border border-[#e3f6f8]">
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- AKSI -->
                <div class="border-t border-[#e3f6f8] pt-6">
                    @auth
                        @if($userParticipation && $userParticipation->status !== 'cancelled')
                            <div class="rounded-2xl bg-[#f0f9fa] p-4 text-sm text-[#3d6473]">
                                <span class="font-semibold text-[#17384d]">Status pendaftaran Anda:</span>
                                {{ $participationLabel[$userParticipation->status] ?? ucfirst((string) $userParticipation->status) }}
                            </div>

                            @if($userParticipation->status !== 'attended')
                                <form method="POST" action="{{ route('public.kegiatans.cancel', $kegiatan->id_kegiatan) }}"
                                      class="mt-4" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-5 py-2.5 rounded-xl border border-rose-200 text-rose-600 font-medium hover:bg-rose-50 transition">
                                        Batalkan Pendaftaran
                                    </button>
                                </form>
                            @endif
                        @elseif($kegiatan->status === 'dibatalkan')
                            <p class="text-sm text-[#7da0ad]">Kegiatan ini telah dibatalkan oleh penyelenggara.</p>
                        @elseif($isPast)
                            <p class="text-sm text-[#7da0ad]">Kegiatan ini sudah berlalu.</p>
                        @elseif(!$availableSlots)
                            <p class="text-sm text-rose-600 font-medium">Maaf, kuota kegiatan ini sudah penuh.</p>
                        @else
                            <form method="POST" action="{{ route('public.kegiatans.register', $kegiatan->id_kegiatan) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="notes" class="block text-xs font-semibold text-gray-600 mb-1">Catatan (opsional)</label>
                                    <textarea id="notes" name="notes" rows="3" maxlength="500"
                                              class="w-full border border-[#d5ebee] rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]"
                                              placeholder="Contoh: saya ingin bertanya tentang materi kegiatan...">{{ old('notes') }}</textarea>
                                </div>
                                <button type="submit"
                                        class="px-6 py-3 rounded-xl bg-[#56b8c2] hover:bg-[#3d9aa3] text-white font-semibold transition">
                                    Daftar Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="rounded-2xl border border-[#e3f6f8] bg-[#f8feff] p-5 text-sm text-[#3d6473]">
                            Silakan login terlebih dahulu untuk mendaftar kegiatan ini.
                            <a href="{{ route('login') }}" class="ml-1 font-semibold text-[#14b8c4] hover:text-[#0e9aa5]">Login</a>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
