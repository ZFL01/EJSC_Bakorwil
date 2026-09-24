@extends('layouts.admin')

@section('title', 'Detail Booking Ruangan')
@section('header', 'Detail Booking Ruangan')

@section('content')

<div class="min-h-full bg-gradient-to-br from-slate-50 via-cyan-50/30 to-slate-50">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-5 pb-12">

        {{-- =========================================================
             MAIN CARD
        ========================================================== --}}
        <div class="bg-white rounded-[28px] shadow-lg shadow-gray-200/50 overflow-hidden border border-gray-100">


            {{-- =====================================================
                 HEADER
            ====================================================== --}}
            <div class="relative bg-gradient-to-br from-[#0b4654] via-[#0d6668] to-[#126d72] px-6 sm:px-7 pt-6 pb-8 overflow-hidden">

                {{-- Decorative background --}}
                <div class="absolute -top-20 -right-20 w-52 h-52 rounded-full bg-cyan-300/10"></div>
                <div class="absolute -bottom-24 -left-16 w-48 h-48 rounded-full bg-teal-300/10"></div>

                <div class="relative">

                    {{-- STATUS --}}
                    <div class="flex justify-end mb-5">

                        @php
                            $statusConfig = [
                                'menunggu' => [
                                    'label' => 'MENUNGGU',
                                    'dot' => 'bg-amber-300',
                                    'class' => 'bg-amber-400/10 text-amber-200 border-amber-300/30'
                                ],
                                'disetujui' => [
                                    'label' => 'DISETUJUI',
                                    'dot' => 'bg-emerald-300',
                                    'class' => 'bg-emerald-400/10 text-emerald-200 border-emerald-300/30'
                                ],
                                'ditolak' => [
                                    'label' => 'DITOLAK',
                                    'dot' => 'bg-rose-300',
                                    'class' => 'bg-rose-400/10 text-rose-200 border-rose-300/30'
                                ],
                                'selesai' => [
                                    'label' => 'SELESAI',
                                    'dot' => 'bg-sky-300',
                                    'class' => 'bg-sky-400/10 text-sky-200 border-sky-300/30'
                                ],
                                'dibatalkan' => [
                                    'label' => 'DIBATALKAN',
                                    'dot' => 'bg-gray-300',
                                    'class' => 'bg-gray-400/10 text-gray-200 border-gray-300/30'
                                ],
                            ];

                            $config = $statusConfig[$booking->status] ?? [
                                'label' => strtoupper($booking->status),
                                'dot' => 'bg-gray-300',
                                'class' => 'bg-gray-400/10 text-gray-200 border-gray-300/30'
                            ];
                        @endphp

                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ $config['class'] }} backdrop-blur-sm text-xs sm:text-sm font-bold tracking-wide"
                        >
                            <span class="w-2.5 h-2.5 rounded-full {{ $config['dot'] }}"></span>
                            {{ $config['label'] }}
                        </span>

                    </div>


                    {{-- KICKER --}}
                    <div class="flex items-center gap-2 mb-2">

                        <svg
                            class="w-5 h-5 text-cyan-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>

                        <span class="text-cyan-300 text-sm font-bold uppercase tracking-wide">
                            Detail Pemesanan
                        </span>

                    </div>


                    {{-- TITLE --}}
                    <div class="flex items-end justify-between gap-4">

                        <h1 class="text-3xl sm:text-[34px] leading-tight font-bold text-white tracking-tight">
                            Detail Booking
                        </h1>

                    </div>


                    {{-- ROOM --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mt-5">

                        <div
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15"
                        >

                            <svg
                                class="w-5 h-5 text-cyan-200 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"
                                />
                            </svg>

                            <span class="text-white font-semibold text-sm sm:text-base leading-tight">
                                {{ $booking->room->name ?? 'Ruangan' }}
                            </span>

                        </div>


                        <div
                            class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-cyan-400/10 border border-cyan-300/20"
                        >

                            <svg
                                class="w-5 h-5 text-cyan-200 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 6v6l4 2"
                                />
                            </svg>

                            <span class="text-cyan-100 font-semibold text-sm sm:text-base">
                                Ruang Pertemuan
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 BODY
            ====================================================== --}}
            <div class="px-5 sm:px-7 py-6">


                {{-- =================================================
                     DATE + TIME
                ================================================== --}}

                @php
                    $startTime = \Carbon\Carbon::parse($booking->time_start);
                    $endTime = \Carbon\Carbon::parse($booking->time_end);

                    if ($endTime->lessThan($startTime)) {
                        $endTime->addDay();
                    }

                    $totalMinutes = $startTime->diffInMinutes($endTime);

                    $durationHours = intdiv($totalMinutes, 60);
                    $durationMinutes = $totalMinutes % 60;
                @endphp


                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- DATE --}}
                    <div class="flex items-center gap-4 px-5 py-4">

                        {{-- CALENDAR ICON --}}
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0"
                        >

                            <svg
                                class="w-6 h-6 text-amber-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>

                        </div>


                        {{-- DATE --}}
                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                Tanggal Pemakaian
                            </p>

                            <p class="text-lg font-bold text-slate-800 mt-0.5">

                                @if($booking->date)

                                    {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y') }}

                                @else

                                    -

                                @endif

                            </p>

                        </div>


                        {{-- DURASI --}}
                        <div
                            class="flex-shrink-0 min-w-[136px] px-3 py-1.5 rounded-full bg-cyan-50 border border-cyan-200 text-center"
                        >

                            <span class="block text-sm font-semibold text-cyan-700 leading-tight">

                                @if($durationHours > 0)

                                    {{ $durationHours }} Jam

                                    @if($durationMinutes > 0)
                                        {{ $durationMinutes }} Menit
                                    @endif

                                @else

                                    {{ $durationMinutes }} Menit

                                @endif

                            </span>

                        </div>

                    </div>


                    {{-- DIVIDER --}}
                    <div class="mx-5 border-t border-gray-100"></div>


                    {{-- TIME --}}
                    <div class="flex items-center gap-4 px-5 py-4">

                        {{-- CLOCK ICON --}}
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-shrink-0"
                        >

                            <svg
                                class="w-6 h-6 text-emerald-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                        </div>


                        {{-- TIME --}}
                        <div class="min-w-0">

                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                Waktu Rapat
                            </p>

                            <p class="text-lg font-bold text-slate-800 mt-0.5">

                                {{ substr($booking->time_start, 0, 5) }}

                                –

                                {{ substr($booking->time_end, 0, 5) }}

                                <span class="text-sm font-semibold text-slate-400">
                                    WIB
                                </span>

                            </p>

                        </div>


                        {{-- ROOM READY --}}
                        <div class="ml-auto flex items-center gap-1.5 text-emerald-600 font-semibold text-sm">

                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                            Room Ready

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     INFORMATION GRID
                ================================================== --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">


                    {{-- PEMBOOKING --}}
                    <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-11 h-11 rounded-xl bg-cyan-50 border border-cyan-100 flex items-center justify-center flex-shrink-0"
                            >

                                <svg
                                    class="w-6 h-6 text-cyan-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Pembooking
                                </p>

                                <p class="text-base font-bold text-slate-800 mt-0.5 break-words">
                                    {{ $booking->name ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- INSTANSI --}}
                    <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-11 h-11 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center flex-shrink-0"
                            >

                                <svg
                                    class="w-6 h-6 text-purple-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"
                                    />
                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Instansi
                                </p>

                                <p class="text-base font-bold text-slate-800 mt-0.5 break-words">
                                    {{ $booking->institution ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- PESERTA --}}
                    <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-11 h-11 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0"
                            >

                                <svg
                                    class="w-6 h-6 text-indigo-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>

                            </div>


                            <div>

                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Jumlah Peserta
                                </p>

                                <p class="text-base font-bold text-slate-800 mt-0.5">
                                    {{ $booking->participants ?? 0 }} Orang
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- KEPERLUAN --}}
                    <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center flex-shrink-0"
                            >

                                <svg
                                    class="w-6 h-6 text-rose-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Keperluan
                                </p>

                                <p class="text-base font-bold text-slate-800 mt-0.5 break-words">
                                    {{ $booking->purpose ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FACILITIES
                ================================================== --}}
                <div class="mt-5 p-5 rounded-2xl bg-white border border-gray-100 shadow-sm">

                    <div class="flex items-center gap-3 mb-4">

                        <div
                            class="w-10 h-10 rounded-xl bg-lime-50 border border-lime-100 flex items-center justify-center"
                        >

                            <svg
                                class="w-5 h-5 text-lime-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                                />
                            </svg>

                        </div>


                        <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">
                            Fasilitas Tambahan
                        </p>

                    </div>


                    <div class="flex flex-wrap gap-2">

                        @forelse($booking->facilities ?? [] as $facility)

                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-cyan-50 border border-cyan-200 text-cyan-700 text-sm font-medium"
                            >

                                <svg
                                    class="w-3.5 h-3.5 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                {{ $facility }}

                            </span>

                        @empty

                            <span class="text-sm text-gray-400 italic">
                                Tidak ada fasilitas tambahan
                            </span>

                        @endforelse

                    </div>

                </div>


                {{-- =================================================
                     ACTION: MENUNGGU
                ================================================== --}}
                @if($booking->status === 'menunggu')

                    <div class="mt-6 pt-6 border-t border-gray-100">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                            {{-- APPROVE --}}
                            <form
                                method="POST"
                                action="{{ route('admin.bookings.approve', $booking->id) }}"
                                onsubmit="return confirm('Setujui booking ini?')"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full min-h-[48px] inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold transition-all shadow-sm"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2.5"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>

                                    Setujui

                                </button>

                            </form>


                            {{-- REJECT --}}
                            <button
                                type="button"
                                onclick="document.getElementById('rejectForm').classList.toggle('hidden')"
                                class="w-full min-h-[48px] inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 text-sm font-bold transition-all"
                            >

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                                Tolak

                            </button>


                            {{-- CANCEL --}}
                            <form
                                method="POST"
                                action="{{ route('admin.bookings.cancel', $booking->id) }}"
                                onsubmit="return confirm('Batalkan booking ini?')"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full min-h-[48px] inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-bold transition-all"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="8.5"
                                            stroke-width="2"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="2"
                                            d="M8.5 8.5l7 7"
                                        />
                                    </svg>

                                    Batalkan

                                </button>

                            </form>

                        </div>


                        {{-- REJECT FORM --}}
                        <form
                            id="rejectForm"
                            method="POST"
                            action="{{ route('admin.bookings.reject', $booking->id) }}"
                            class="hidden mt-4"
                        >

                            @csrf

                            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100">

                                <label class="block text-sm font-bold text-rose-700 mb-2">
                                    Alasan Penolakan
                                </label>

                                <textarea
                                    name="admin_note"
                                    required
                                    rows="3"
                                    class="w-full rounded-xl border border-rose-200 bg-white p-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 resize-none"
                                    placeholder="Masukkan alasan penolakan..."
                                ></textarea>

                                <button
                                    type="submit"
                                    class="mt-3 inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold"
                                >
                                    Konfirmasi Penolakan
                                </button>

                            </div>

                        </form>

                    </div>

                @endif


                {{-- =================================================
                     ACTION: DISETUJUI
                ================================================== --}}
                @if($booking->status === 'disetujui')

                    <div class="mt-6 pt-6 border-t border-gray-100">

                        {{-- TANDAI SELESAI --}}
                        <form
                            method="POST"
                            action="{{ route('admin.bookings.complete', $booking->id) }}"
                            onsubmit="return confirm('Tandai booking sebagai selesai?')"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="w-full min-h-[54px] inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-[#111827] hover:bg-[#0b1220] text-white text-base font-bold transition-all shadow-md"
                            >

                                <svg
                                    class="w-5 h-5 text-emerald-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M8 12.5l2.5 2.5L16 9"
                                    />
                                </svg>

                                Tandai Selesai

                            </button>

                        </form>


                        {{-- BATALKAN BOOKING --}}
                        <form
                            method="POST"
                            action="{{ route('admin.bookings.cancel', $booking->id) }}"
                            onsubmit="return confirm('Batalkan booking ini?')"
                            class="mt-3"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="w-full min-h-[54px] inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-600 text-base font-bold transition-all"
                            >

                              {{-- ICON BATALKAN --}}
                                <svg
                                    class="w-5 h-5 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="2.5"
                                    />

                                    <path
                                        d="M5.64 5.64L18.36 18.36"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                    />
                                </svg>

                                <span>
                                    Batalkan Booking
                                </span>

                            </button>

                        </form>

                    </div>

                @endif


                {{-- =================================================
                     ADMIN NOTE
                ================================================== --}}
                @if($booking->admin_note)

                    <div class="mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-100">

                        <div class="flex items-start gap-3">

                            <div
                                class="w-9 h-9 rounded-xl bg-rose-500 flex items-center justify-center flex-shrink-0"
                            >

                                <svg
                                    class="w-4 h-4 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-2.99l-6.93-12a2 2 0 00-3.48 0l-6.93 12A2 2 0 005.07 19z"
                                    />
                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">
                                    Catatan Admin
                                </p>

                                <p class="text-sm text-rose-700 mt-1 font-medium break-words">
                                    {{ $booking->admin_note }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- =================================================
                     BACK LINK
                ================================================== --}}
                <div class="text-center mt-6">

                    <a
                        href="{{ route('admin.bookings.index') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#0e4f81] transition-colors"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>

                        Kembali ke daftar booking

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection