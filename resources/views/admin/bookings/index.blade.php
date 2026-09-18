@extends('layouts.admin')

@section('title', 'Booking Room')
@section('header', 'Booking Room')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        NOTIFICATION
    ========================================================== --}}

    @if(session('success'))
        <div class="relative overflow-hidden flex items-start gap-3 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-2xl shadow-sm animate-fade-in">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-emerald-200/30 blur-2xl"></div>

            <div class="relative flex-shrink-0 w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-md shadow-emerald-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div class="relative">
                <p class="text-sm font-bold text-emerald-800">Berhasil</p>
                <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif


    @if(session('error'))
        <div class="relative overflow-hidden flex items-start gap-3 p-4 bg-gradient-to-r from-rose-50 to-pink-50 border border-rose-200 rounded-2xl shadow-sm animate-fade-in">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-rose-200/30 blur-2xl"></div>

            <div class="relative flex-shrink-0 w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-md shadow-rose-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div class="relative">
                <p class="text-sm font-bold text-rose-800">Terjadi Kesalahan</p>
                <p class="text-sm text-rose-700 mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
    @endif


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#0e4f81] to-[#56b8c2] bg-clip-text text-transparent">
                Booking Room
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Kelola pengajuan penggunaan ruangan EJSC Bakorwil Jember.
            </p>
        </div>

        <div class="flex items-center gap-3">

            <a
                href="{{ route('admin.bookings.rooms.create') }}"
                class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-[#0e4f81] text-white text-sm font-semibold shadow-md shadow-[#0e4f81]/20 hover:bg-[#0b416b] transition-all duration-200"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                </svg>
                Tambah Ruangan
            </a>

            <div class="group relative overflow-hidden px-5 py-3 bg-gradient-to-br from-white to-slate-50 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md hover:border-[#56b8c2]/40 transition-all duration-300">
                <div class="absolute -top-6 -right-6 w-16 h-16 rounded-full bg-[#56b8c2]/10 group-hover:bg-[#56b8c2]/20 transition-colors"></div>

                <div class="relative flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#56b8c2] to-[#0e4f81] flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                            Total Booking
                        </span>
                        <span class="text-lg font-bold text-slate-800 leading-none mt-0.5">
                            {{ $bookings->total() }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- =========================================================
        ROOM MANAGEMENT
    ========================================================== --}}

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Ruangan</h3>
                <p class="text-sm text-slate-500 mt-1">Kelola ruangan yang tampil pada halaman booking publik.</p>
            </div>
            <a
                href="{{ route('admin.bookings.rooms.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-[#56b8c2] text-[#0e4f81] text-sm font-semibold hover:bg-[#eef9fb] transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                </svg>
                Ruangan Baru
            </a>
        </div>

        @if($rooms->isEmpty())
            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500">
                Belum ada ruangan. Tambahkan ruangan untuk membuka pilihan booking.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                @foreach($rooms as $room)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-4 hover:border-[#56b8c2]/50 transition">
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800 truncate">{{ $room->name }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-xs text-slate-500">Kapasitas {{ $room->capacity }} orang</p>
                                <span class="text-[10px] font-semibold {{ $room->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ $room->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('admin.bookings.rooms.destroy', $room) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                onclick="return confirm('Hapus ruangan {{ addslashes($room->name) }}? Ruangan yang sudah dipakai booking tidak dapat dihapus.')"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-rose-600 hover:bg-rose-50 transition"
                                title="Hapus ruangan"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12m-10 0v10m4-10v10m4-10v10M9 7V4h6v3m-8 0h10l-.7 13H7.7L7 7z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


    {{-- =========================================================
        FILTER
    ========================================================== --}}

    <div class="relative bg-white rounded-2xl border border-slate-200 shadow-sm p-6 overflow-hidden">

        {{-- Decorative gradient --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#0e4f81] via-[#56b8c2] to-[#0e4f81]"></div>

        <form
            action="{{ route('admin.bookings.index') }}"
            method="GET"
        >

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

                {{-- Search --}}
                <div class="lg:col-span-2">

                    <label
                        for="search"
                        class="flex items-center gap-1.5 text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide"
                    >
                        <svg class="w-3.5 h-3.5 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/>
                        </svg>
                        Cari Booking
                    </label>

                    <div class="relative group">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg
                                class="w-4 h-4 text-slate-400 group-focus-within:text-[#56b8c2] transition-colors"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/>
                            </svg>
                        </div>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Nama, instansi, atau WhatsApp..."
                            class="w-full pl-10 pr-3 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition-all duration-200"
                        >

                    </div>

                </div>


                {{-- Room --}}
                <div>

                    <label
                        for="room_id"
                        class="flex items-center gap-1.5 text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide"
                    >
                        <svg class="w-3.5 h-3.5 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                        </svg>
                        Ruangan
                    </label>

                    <select
                        name="room_id"
                        id="room_id"
                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition-all duration-200 cursor-pointer"
                    >

                        <option value="">Semua Ruangan</option>

                        @foreach($rooms as $room)
                            <option
                                value="{{ $room->id }}"
                                {{ request('room_id') == $room->id ? 'selected' : '' }}
                            >
                                {{ $room->name }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label
                        for="status"
                        class="flex items-center gap-1.5 text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide"
                    >
                        <svg class="w-3.5 h-3.5 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition-all duration-200 cursor-pointer"
                    >

                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>🟡 Menunggu</option>
                        <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>🟢 Disetujui</option>
                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>🔴 Ditolak</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>🔵 Selesai</option>
                        <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>⚪ Dibatalkan</option>

                    </select>

                </div>


                {{-- Date --}}
                <div>

                    <label
                        for="date"
                        class="flex items-center gap-1.5 text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide"
                    >
                        <svg class="w-3.5 h-3.5 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="date"
                        value="{{ request('date') }}"
                        class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition-all duration-200"
                    >

                </div>

            </div>


            {{-- Filter Buttons --}}
            <div class="flex flex-wrap items-center gap-2 mt-5 pt-5 border-t border-slate-100">

                <button
                    type="submit"
                    class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#0e4f81] to-[#56b8c2] text-white text-sm font-semibold shadow-md shadow-[#56b8c2]/20 hover:shadow-lg hover:shadow-[#56b8c2]/30 transition-all duration-200"
                >

                    <svg
                        class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 12.414V19l-4 2v-8.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>

                    Terapkan Filter

                </button>


                @if(request()->hasAny(['search', 'room_id', 'status', 'date']))
                    <a
                        href="{{ route('admin.bookings.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-slate-50 hover:border-rose-200 hover:text-rose-600 transition-all duration-200"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>

                        Reset

                    </a>
                @endif

            </div>

        </form>

    </div>


    {{-- =========================================================
        TABLE
    ========================================================== --}}

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-slate-200">

                    <tr>

                        <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Pembooking
                        </th>

                        <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Instansi
                        </th>

                        <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Ruangan
                        </th>

                        <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Tanggal
                        </th>

                        <th class="px-5 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Waktu
                        </th>

                        <th class="px-5 py-4 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Peserta
                        </th>

                        <th class="px-5 py-4 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Status
                        </th>

                        <th class="px-5 py-4 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($bookings as $booking)

                        <tr class="hover:bg-gradient-to-r hover:from-[#56b8c2]/5 hover:to-transparent transition-all duration-200 group">

                            {{-- Pembooking --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#56b8c2] to-[#0e4f81] flex items-center justify-center flex-shrink-0 shadow-sm shadow-cyan-500/20 group-hover:scale-105 transition-transform duration-200">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($booking->name, 0, 1)) }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="font-semibold text-slate-800 truncate">
                                            {{ $booking->name }}
                                        </p>

                                        @if($booking->whatsapp)
                                            <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                {{ $booking->whatsapp }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Instansi --}}
                            <td class="px-5 py-4">
                                <span class="text-slate-700 font-medium">
                                    {{ $booking->institution ?? '-' }}
                                </span>
                            </td>


                            {{-- Ruangan --}}
                            <td class="px-5 py-4">

                                @if($booking->room)

                                    <div class="flex items-start gap-2">

                                        <div class="w-1.5 h-1.5 rounded-full bg-[#56b8c2] mt-1.5 flex-shrink-0"></div>

                                        <div>
                                            <p class="font-medium text-slate-800">
                                                {{ $booking->room->name }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Kapasitas {{ $booking->room->capacity }} orang
                                            </p>
                                        </div>

                                    </div>

                                @else

                                    <span class="inline-flex items-center gap-1 text-rose-500 text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-2.99l-6.93-12a2 2 0 00-3.48 0l-6.93 12A2 2 0 005.07 19z"/>
                                        </svg>
                                        Ruangan tidak ditemukan
                                    </span>

                                @endif

                            </td>


                            {{-- Tanggal --}}
                            <td class="px-5 py-4">

                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700">

                                    <svg
                                        class="w-3.5 h-3.5 text-[#56b8c2] flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>

                                    <span class="whitespace-nowrap text-xs font-semibold">

                                        @if($booking->date)
                                            {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}
                                        @else
                                            -
                                        @endif

                                    </span>

                                </div>

                            </td>


                            {{-- Waktu --}}
                            <td class="px-5 py-4">

                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-700">

                                    <svg
                                        class="w-3.5 h-3.5 flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>

                                    <span class="whitespace-nowrap text-xs font-semibold">
                                        {{ \Carbon\Carbon::parse($booking->time_start)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($booking->time_end)->format('H:i') }}
                                    </span>

                                </div>

                            </td>


                            {{-- Peserta --}}
                            <td class="px-5 py-4 text-center">

                                <span class="inline-flex items-center justify-center gap-1.5 min-w-[44px] px-2.5 py-1.5 rounded-lg bg-gradient-to-br from-purple-50 to-indigo-50 text-purple-700 font-bold text-xs border border-purple-100">

                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>

                                    {{ $booking->participants }}

                                </span>

                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4 text-center">

                                @php
                                    $statusConfig = [
                                        'menunggu'   => ['label' => 'Menunggu',   'class' => 'bg-amber-100 text-amber-700 border-amber-200',     'dot' => 'bg-amber-500'],
                                        'disetujui'  => ['label' => 'Disetujui',  'class' => 'bg-emerald-100 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
                                        'ditolak'    => ['label' => 'Ditolak',    'class' => 'bg-rose-100 text-rose-700 border-rose-200',       'dot' => 'bg-rose-500'],
                                        'selesai'    => ['label' => 'Selesai',    'class' => 'bg-sky-100 text-sky-700 border-sky-200',          'dot' => 'bg-sky-500'],
                                        'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-slate-100 text-slate-600 border-slate-200',    'dot' => 'bg-slate-400'],
                                    ];
                                    $config = $statusConfig[$booking->status] ?? [
                                        'label' => ucfirst($booking->status),
                                        'class' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        'dot' => 'bg-slate-400',
                                    ];
                                @endphp

                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border {{ $config['class'] }} text-xs font-bold whitespace-nowrap">

                                    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }} animate-pulse"></span>

                                    {{ $config['label'] }}

                                </span>

                            </td>


                            {{-- Aksi --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-1.5 flex-wrap">

                                    {{-- Detail --}}
                                    <a
                                        href="{{ route('admin.bookings.show', $booking->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-[#56b8c2] hover:bg-[#56b8c2]/10 hover:scale-110 transition-all duration-200"
                                        title="Detail"
                                    >

                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>

                                    </a>


                                    {{-- =================================================
                                        STATUS MENUNGGU
                                    ================================================== --}}

                                    @if($booking->status === 'menunggu')

                                        {{-- Setujui --}}
                                        <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="inline">

                                            @csrf

                                            <button
                                                type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui booking ini?')"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-emerald-600 hover:bg-emerald-50 hover:scale-110 transition-all duration-200"
                                                title="Setujui"
                                            >

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>

                                            </button>

                                        </form>


                                        {{-- Tolak --}}
                                        <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="inline">

                                            @csrf

                                            <button
                                                type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menolak booking ini?')"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-rose-600 hover:bg-rose-50 hover:scale-110 transition-all duration-200"
                                                title="Tolak"
                                            >

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>

                                            </button>

                                        </form>

                                    @endif


                                    {{-- =================================================
                                        STATUS DISETUJUI
                                    ================================================== --}}

                                    @if($booking->status === 'disetujui')

                                        {{-- Selesai --}}
                                        <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="inline">

                                            @csrf

                                            <button
                                                type="submit"
                                                onclick="return confirm('Tandai booking ini sebagai selesai?')"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sky-600 hover:bg-sky-50 hover:scale-110 transition-all duration-200"
                                                title="Tandai Selesai"
                                            >

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>

                                            </button>

                                        </form>

                                    @endif


                                    {{-- =================================================
                                        STATUS MENUNGGU / DISETUJUI - Batal
                                    ================================================== --}}

                                    @if(in_array($booking->status, ['menunggu', 'disetujui']))

                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline">

                                            @csrf

                                            <button
                                                type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 hover:scale-110 transition-all duration-200"
                                                title="Batalkan"
                                            >

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-5 py-16 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center mb-4 border border-slate-200">

                                        <svg
                                            class="w-10 h-10 text-slate-300"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>

                                    </div>

                                    <h3 class="text-base font-bold text-slate-700">
                                        Belum Ada Booking
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1 max-w-xs">
                                        Belum ada data booking yang sesuai dengan filter yang Anda pilih.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}

        @if($bookings->hasPages())

            <div class="px-5 py-4 border-t border-slate-100 bg-gradient-to-r from-slate-50/50 to-white">
                {{ $bookings->links() }}
            </div>

        @endif

    </div>

</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.35s ease-out;
    }
</style>

@endsection