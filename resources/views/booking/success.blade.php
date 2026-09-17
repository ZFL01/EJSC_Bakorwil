@extends('layouts.app')

@section('title', 'Booking Berhasil')

@section('content')

<div class="min-h-screen bg-[#f8fbfc] py-10 px-4 relative overflow-hidden">

    {{-- Dekorasi background halus --}}
    <div class="absolute top-20 -left-20 w-96 h-96 bg-[#56b8c2]/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-20 -right-20 w-96 h-96 bg-[#0e4f81]/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative">

        {{-- SUCCESS CARD --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-fade-in-up">

            {{-- HEADER --}}
            <div class="relative px-6 sm:px-8 py-10 text-center border-b border-gray-100 overflow-hidden">

                {{-- Dekorasi --}}
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-80 h-80 bg-green-100/40 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#56b8c2]/8 rounded-full blur-2xl"></div>

                {{-- Pattern titik halus --}}
                <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, #0e4f81 1px, transparent 1px); background-size: 24px 24px;"></div>

                <div class="relative">

                    {{-- Icon Success dengan animasi draw --}}
                    <div class="mx-auto w-20 h-20 rounded-full bg-white flex items-center justify-center mb-5 relative shadow-lg shadow-green-500/10">

                        <span class="absolute inset-0 rounded-full bg-green-200/40 animate-ping-slow"></span>

                        <div class="relative w-14 h-14 rounded-full bg-green-500 flex items-center justify-center shadow-lg shadow-green-500/30">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    class="checkmark-path"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="3"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>

                    </div>


                    <h1 class="text-2xl sm:text-3xl font-bold text-[#0e4f81] animate-fade-in-up" style="animation-delay: 0.15s;">
                        Booking Berhasil Diajukan
                    </h1>

                    <p class="text-gray-500 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.25s;">
                        Permintaan booking Anda telah diterima dan
                        sedang menunggu konfirmasi dari admin EJSC.
                    </p>


                    <div class="mt-5 flex justify-center animate-fade-in-up" style="animation-delay: 0.35s;">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm font-semibold">
                            <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                            Menunggu Persetujuan
                        </span>
                    </div>

                </div>

            </div>


            {{-- BOOKING DETAIL --}}
            <div class="px-6 sm:px-8 py-7">

                <div class="flex items-center justify-between mb-5">

                    <div>
                        <h2 class="text-lg font-bold text-[#0e4f81]">
                            Detail Booking
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Informasi pengajuan penggunaan ruangan.
                        </p>
                    </div>


                    <div class="text-right">
                        <p class="text-xs text-gray-400">ID Booking</p>
                        <p class="text-sm font-bold text-[#0e4f81] font-mono tracking-tight">
                            #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                </div>


                <div class="border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100">

                    {{-- Ruangan --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                            </svg>
                            Ruangan
                        </div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $booking->room->name ?? 'Ruangan tidak ditemukan' }}
                        </div>
                    </div>


                    {{-- Tanggal --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Tanggal
                        </div>
                        <div class="text-sm font-semibold text-gray-800">
                            @if($booking->date)
                                {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>


                    {{-- Waktu --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Waktu
                        </div>
                        <div class="text-sm font-semibold text-gray-800">
                            @if($booking->time_start && $booking->time_end)
                                {{ \Carbon\Carbon::parse($booking->time_start)->format('H:i') }}
                                <span class="text-gray-400 mx-1">—</span>
                                {{ \Carbon\Carbon::parse($booking->time_end)->format('H:i') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>


                    {{-- Pembooking --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Pembooking
                        </div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $booking->name ?? '-' }}
                        </div>
                    </div>


                    {{-- Instansi --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                            </svg>
                            Instansi
                        </div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $booking->institution ?? '-' }}
                        </div>
                    </div>


                    {{-- Peserta --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Jumlah Peserta
                        </div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $booking->participants ?? 0 }} orang
                        </div>
                    </div>


                    {{-- Tujuan --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2 pt-0.5">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Tujuan
                        </div>
                        <div class="text-sm font-semibold text-gray-800 leading-relaxed">
                            {{ $booking->purpose ?? '-' }}
                        </div>
                    </div>


                    {{-- Fasilitas --}}
                    <div class="detail-row flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-5 px-5 py-4 hover:bg-gray-50/60 transition-colors duration-200">
                        <div class="w-full sm:w-44 text-sm text-gray-500 font-medium flex items-center gap-2 pt-0.5">
                            <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Fasilitas Tambahan
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @if(!empty($booking->facilities) && is_array($booking->facilities))
                                @foreach($booking->facilities as $facility)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#eef9fb] text-[#0e4f81] text-xs font-medium border border-[#56b8c2]/20">
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-sm text-gray-400">Tidak ada</span>
                            @endif
                        </div>
                    </div>

                </div>


                {{-- INFORMATION --}}
                <div class="mt-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 animate-fade-in-up" style="animation-delay: 0.5s;">

                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                            <svg
                                class="w-4 h-4 text-yellow-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                />
                            </svg>
                        </div>

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-yellow-800">
                                Menunggu Persetujuan Admin
                            </p>

                            <p class="text-xs sm:text-sm text-yellow-700 mt-1 leading-relaxed">
                                Pengajuan booking Anda sedang menunggu pemeriksaan
                                dan persetujuan dari admin. Jadwal baru dianggap
                                resmi setelah booking disetujui.
                            </p>

                            <p class="text-xs sm:text-sm text-yellow-700 mt-2 leading-relaxed">
                                Setelah melakukan booking, silakan menghubungi admin
                                melalui WhatsApp untuk mendapatkan informasi terkait
                                surat perizinan dari kantor pemerintah pusat.
                            </p>

                            {{-- TOMBOL WHATSAPP --}}
                            <a
                                href="https://wa.me/6287838522297?text={{ urlencode('Halo Admin EJSC, saya telah melakukan booking ruangan dan ingin mendapatkan informasi terkait surat perizinan dari kantor pemerintah pusat.') }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-lg bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md hover:shadow-green-500/30 active:scale-[0.98]"
                            >

                                <svg
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.5-.67-.51-.173-.008-.372-.01-.57-.01-.198 0-.52.075-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.847 1.213 3.045.149.198 2.095 3.2 5.076 4.487.709.306 1.262.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                </svg>

                                Hubungi Admin via WhatsApp

                            </a>

                        </div>

                    </div>

                </div>


                {{-- ACTION BUTTON --}}
                <div class="flex flex-col sm:flex-row gap-3 mt-7">

                    <a
                        href="{{ route('booking.schedule', [
                            'room_id' => $booking->room_id,
                            'date' => $booking->date
                                ? \Carbon\Carbon::parse($booking->date)->format('Y-m-d')
                                : now()->format('Y-m-d')
                        ]) }}"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#0e4f81] text-white text-sm font-semibold hover:bg-[#0a3d64] hover:shadow-lg hover:shadow-[#0e4f81]/20 active:scale-[0.98] transition-all duration-200"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Lihat Jadwal
                    </a>


                    @auth
                        <a
                            href="{{ route('booking.my') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 active:scale-[0.98] transition-all duration-200"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Booking Saya
                        </a>
                    @endauth

                </div>


                {{-- Back --}}
                <div class="text-center mt-5">
                    <a
                        href="{{ route('booking.index') }}"
                        class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#0e4f81] transition-colors duration-200 group"
                    >
                        <span class="group-hover:-translate-x-1 transition-transform duration-200">←</span>
                        Kembali ke Booking Ruangan
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>


<style>
    @keyframes ping-slow {
        75%, 100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes draw-check {
        from {
            stroke-dashoffset: 30;
        }
        to {
            stroke-dashoffset: 0;
        }
    }

    .animate-ping-slow {
        animation: ping-slow 2.2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .checkmark-path {
        stroke-dasharray: 30;
        stroke-dashoffset: 30;
        animation: draw-check 0.6s cubic-bezier(0.65, 0, 0.45, 1) 0.4s forwards;
    }

    /* Hover reveal untuk setiap row detail */
    .detail-row {
        position: relative;
    }

    .detail-row::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #56b8c2;
        transform: scaleY(0);
        transform-origin: center;
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .detail-row:hover::before {
        transform: scaleY(1);
    }
</style>

@endsection