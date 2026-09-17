@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-cyan-50/30 to-slate-50 py-10">

    <div class="max-w-4xl mx-auto px-6">

        {{-- Back Button --}}
        <a
            href="{{ route('admin.bookings.index') }}"
            class="inline-flex items-center gap-2 text-[#0e4f81] text-sm font-medium hover:gap-3 transition-all duration-200 group"
        >
            <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center group-hover:shadow-md transition-shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </div>
            Kembali ke daftar booking
        </a>


        {{-- Main Card --}}
        <div class="bg-white border border-gray-100 rounded-3xl shadow-lg shadow-gray-200/50 mt-5 overflow-hidden">

            {{-- Header --}}
            <div class="relative px-6 md:px-8 py-6 bg-gradient-to-r from-[#0e4f81] via-[#1a6fa8] to-[#56b8c2] overflow-hidden">

                {{-- Decorative circles --}}
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-16 -left-8 w-32 h-32 rounded-full bg-white/5"></div>

                <div class="relative flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-white/80 text-xs font-semibold uppercase tracking-wider">Detail Pemesanan</span>
                        </div>
                        <h1 class="text-2xl font-bold text-white">
                            Detail Booking
                        </h1>
                        <p class="text-white/80 mt-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $booking->room->name }}
                        </p>
                    </div>


                    @php
                        $statusConfig = [
                            'pending' => ['label' => 'Menunggu Persetujuan', 'class' => 'bg-amber-400/20 text-amber-50 border-amber-300/30', 'dot' => 'bg-amber-300', 'icon' => '🟡'],
                            'approved' => ['label' => 'Disetujui', 'class' => 'bg-emerald-400/20 text-emerald-50 border-emerald-300/30', 'dot' => 'bg-emerald-300', 'icon' => '🟢'],
                            'rejected' => ['label' => 'Ditolak', 'class' => 'bg-rose-400/20 text-rose-50 border-rose-300/30', 'dot' => 'bg-rose-300', 'icon' => '🔴'],
                            'completed' => ['label' => 'Selesai', 'class' => 'bg-sky-400/20 text-sky-50 border-sky-300/30', 'dot' => 'bg-sky-300', 'icon' => '🔵'],
                            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-gray-400/20 text-gray-50 border-gray-300/30', 'dot' => 'bg-gray-300', 'icon' => '⚪'],
                        ];
                        $config = $statusConfig[$booking->status] ?? ['label' => $booking->status, 'class' => 'bg-gray-400/20 text-gray-50 border-gray-300/30', 'dot' => 'bg-gray-300', 'icon' => '⚪'];
                    @endphp

                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ $config['class'] }} backdrop-blur font-semibold text-sm whitespace-nowrap self-start md:self-center">
                        <span class="w-2 h-2 rounded-full {{ $config['dot'] }} animate-pulse"></span>
                        {{ $config['label'] }}
                    </span>

                </div>
            </div>


            {{-- Body --}}
            <div class="p-6 md:p-8">

                <div class="grid md:grid-cols-2 gap-5">

                    {{-- Pembooking --}}
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#56b8c2] to-[#0e4f81] flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pembooking</p>
                                <p class="font-semibold text-gray-800 mt-1 break-words">{{ $booking->name }}</p>
                            </div>
                        </div>
                    </div>


                    {{-- Instansi --}}
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Instansi</p>
                                <p class="font-semibold text-gray-800 mt-1 break-words">{{ $booking->institution ?? '-' }}</p>
                            </div>
                        </div>
                    </div>


                    {{-- Ruangan --}}
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Ruangan</p>
                                <p class="font-semibold text-gray-800 mt-1 break-words">{{ $booking->room->name }}</p>
                            </div>
                        </div>
                    </div>


                    {{-- Tanggal --}}
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</p>
                                <p class="font-semibold text-gray-800 mt-1">
                                    {{ $booking->booking_date ? $booking->booking_date->translatedFormat('d F Y') : ($booking->date ? \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y') : '-') }}
                                </p>
                            </div>
                        </div>
                    </div>


                    {{-- Waktu --}}
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu</p>
                                <p class="font-semibold text-gray-800 mt-1">
                                    {{ substr($booking->start_time ?? $booking->time_start, 0, 5) }}
                                    -
                                    {{ substr($booking->end_time ?? $booking->time_end, 0, 5) }}
                                </p>
                            </div>
                        </div>
                    </div>


                    {{-- Peserta --}}
                    <div class="group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jumlah Peserta</p>
                                <p class="font-semibold text-gray-800 mt-1">
                                    {{ $booking->participant_count ?? $booking->participants ?? 0 }} orang
                                </p>
                            </div>
                        </div>
                    </div>


                    {{-- Keperluan --}}
                    <div class="md:col-span-2 group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Keperluan</p>
                                <p class="font-semibold text-gray-800 mt-1 break-words">{{ $booking->purpose ?? '-' }}</p>
                            </div>
                        </div>
                    </div>


                    {{-- Fasilitas Tambahan --}}
                    <div class="md:col-span-2 group p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-gray-100 hover:border-[#56b8c2]/30 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-lime-400 to-green-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Fasilitas Tambahan</p>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($booking->additional_facilities ?? [] as $facility)
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gradient-to-r from-cyan-50 to-teal-50 text-cyan-700 text-sm font-medium border border-cyan-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ $facility }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-sm italic">Tidak ada fasilitas tambahan</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- =========================================================
                     ACTION BUTTONS
                ========================================================== --}}

                @if($booking->status === 'pending')

                    <div class="border-t border-gray-100 mt-8 pt-8">

                        <div class="flex flex-col md:flex-row gap-3">

                            {{-- Approve --}}
                            <form
                                method="POST"
                                action="{{ route('admin.bookings.approve', $booking->id) }}"
                                onsubmit="return confirm('Setujui booking ini?')"
                                class="flex-1 md:flex-none"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-xl px-6 py-3.5 font-semibold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Setujui Booking
                                </button>
                            </form>


                            {{-- Reject Toggle --}}
                            <button
                                type="button"
                                onclick="document.getElementById('rejectForm').classList.toggle('hidden')"
                                class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-white border-2 border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 rounded-xl px-6 py-3.5 font-semibold transition-all duration-200"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tolak Booking
                            </button>

                        </div>


                        {{-- Reject Form --}}
                        <form
                            id="rejectForm"
                            method="POST"
                            action="{{ route('admin.bookings.reject', $booking->id) }}"
                            class="hidden mt-5 animate-fade-in"
                        >
                            @csrf

                            <div class="p-5 rounded-2xl bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100">

                                <label class="flex items-center gap-2 text-sm font-semibold text-rose-700 mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-2.99l-6.93-12a2 2 0 00-3.48 0l-6.93 12A2 2 0 005.07 19z"/>
                                    </svg>
                                    Alasan Penolakan
                                </label>

                                <textarea
                                    name="admin_note"
                                    required
                                    rows="4"
                                    class="w-full border border-rose-200 rounded-xl p-4 bg-white focus:outline-none focus:ring-2 focus:ring-rose-300 focus:border-rose-300 transition-all duration-200 resize-none"
                                    placeholder="Masukkan alasan penolakan..."></textarea>

                                <button
                                    type="submit"
                                    class="mt-3 inline-flex items-center gap-2 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-600 hover:to-red-700 text-white rounded-xl px-6 py-3 font-semibold shadow-lg shadow-rose-500/20 transition-all duration-200"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Konfirmasi Penolakan
                                </button>

                            </div>

                        </form>

                    </div>

                @endif


                @if($booking->status === 'approved')

                    <div class="border-t border-gray-100 mt-8 pt-8">

                        <form
                            method="POST"
                            action="{{ route('admin.bookings.complete', $booking->id) }}"
                            onsubmit="return confirm('Tandai booking sebagai selesai?')"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-600 to-gray-700 hover:from-slate-700 hover:to-gray-800 text-white rounded-xl px-6 py-3.5 font-semibold shadow-lg shadow-gray-500/20 transition-all duration-200"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tandai Selesai
                            </button>
                        </form>

                    </div>

                @endif


                {{-- Admin Note --}}
                @if($booking->admin_note)

                    <div class="border-t border-gray-100 mt-8 pt-8">

                        <div class="p-5 rounded-2xl bg-gradient-to-br from-red-50 to-rose-50 border border-red-100">

                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-red-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-2.99l-6.93-12a2 2 0 00-3.48 0l-6.93 12A2 2 0 005.07 19z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-red-500 uppercase tracking-wider">Catatan Admin</p>
                                    <p class="text-red-700 mt-1 font-medium">{{ $booking->admin_note }}</p>
                                </div>
                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>

@endsection