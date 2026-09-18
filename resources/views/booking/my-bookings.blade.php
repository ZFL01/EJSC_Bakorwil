@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f8fbfc] py-0">

    <div class="max-w-6xl mx-auto px-4 -mt-10">

        {{-- HEADER --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-[#0e4f81]">
                Booking Saya
            </h1>

            <p class="text-gray-500 mt-2">
                Lihat status semua booking ruangan Anda.
            </p>

        </div>


        {{-- LIST BOOKING --}}
        <div class="space-y-3">

            @forelse($bookings as $booking)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Status sesuai database
                    |--------------------------------------------------------------------------
                    */

                    $statusMap = [

                        'menunggu' => [
                            'text' => 'Menunggu Persetujuan',
                            'class' => 'bg-yellow-100 text-yellow-700',
                            'dot' => 'bg-yellow-500'
                        ],

                        'disetujui' => [
                            'text' => 'Disetujui',
                            'class' => 'bg-green-100 text-green-700',
                            'dot' => 'bg-green-500'
                        ],

                        'ditolak' => [
                            'text' => 'Ditolak',
                            'class' => 'bg-red-100 text-red-700',
                            'dot' => 'bg-red-500'
                        ],

                        'selesai' => [
                            'text' => 'Selesai',
                            'class' => 'bg-slate-100 text-slate-700',
                            'dot' => 'bg-slate-500'
                        ],

                        'dibatalkan' => [
                            'text' => 'Dibatalkan',
                            'class' => 'bg-gray-100 text-gray-500',
                            'dot' => 'bg-gray-400'
                        ],

                    ];


                    $status = $statusMap[$booking->status]
                        ?? [
                            'text' => ucfirst($booking->status),
                            'class' => 'bg-gray-100 text-gray-500',
                            'dot' => 'bg-gray-400'
                        ];

                @endphp


                <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:border-[#56b8c2]/50 hover:shadow-md transition-all duration-300">

                    <div class="flex flex-col md:flex-row md:items-center gap-4">


                        {{-- ICON + INFO --}}
                        <div class="flex items-start gap-4 flex-1">


                            <div class="w-11 h-11 rounded-xl bg-[#eef9fb] flex items-center justify-center flex-shrink-0">

                                <svg
                                    class="w-5 h-5 text-[#0e4f81]"
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


                            <div class="flex-1 min-w-0">


                                {{-- NAMA RUANGAN --}}
                                <h3 class="font-bold text-[#0e4f81] text-base">

                                    {{ $booking->room->name ?? 'Ruangan tidak ditemukan' }}

                                </h3>


                                {{-- TANGGAL & WAKTU --}}
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-gray-600">


                                    {{-- TANGGAL --}}
                                    <span class="inline-flex items-center gap-1.5">

                                        <svg
                                            class="w-3.5 h-3.5 text-[#56b8c2]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2v12a2 2 0 002 2z"
                                            />

                                        </svg>


                                        @if($booking->date)

                                            {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y') }}

                                        @else

                                            -

                                        @endif

                                    </span>


                                    {{-- WAKTU --}}
                                    <span class="inline-flex items-center gap-1.5">

                                        <svg
                                            class="w-3.5 h-3.5 text-[#56b8c2]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />

                                        </svg>


                                        @if($booking->time_start && $booking->time_end)

                                            {{ substr($booking->time_start, 0, 5) }}
                                            -
                                            {{ substr($booking->time_end, 0, 5) }}

                                        @else

                                            -

                                        @endif

                                    </span>

                                </div>


                                {{-- KEPERLUAN --}}
                                <p class="text-gray-500 text-sm mt-1.5 truncate">

                                    {{ $booking->purpose }}

                                </p>

                            </div>

                        </div>


                        {{-- STATUS --}}
                        <div class="flex items-center gap-3 md:flex-shrink-0">


                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap {{ $status['class'] }}">

                                <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>

                                {{ $status['text'] }}

                            </span>


                            <svg
                                class="w-4 h-4 text-gray-400 hidden md:block"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


            @empty


                {{-- TIDAK ADA BOOKING --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center">


                    <div class="w-16 h-16 mx-auto rounded-full bg-[#eef9fb] flex items-center justify-center mb-4">

                        <svg
                            class="w-8 h-8 text-[#56b8c2]"
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


                    <h3 class="font-bold text-[#0e4f81] text-lg">
                        Belum ada booking
                    </h3>


                    <p class="text-gray-500 mt-1">
                        Anda belum memiliki pengajuan booking ruangan.
                    </p>


                    <a
                        href="{{ route('booking.index') }}"
                        class="inline-block mt-5 bg-[#56b8c2] text-white rounded-xl px-6 py-3 font-semibold hover:bg-[#45aab5] hover:shadow-lg hover:shadow-[#56b8c2]/30 active:scale-[0.98] transition-all duration-200"
                    >

                        Booking Ruangan

                    </a>

                </div>


            @endforelse

        </div>


        {{-- PAGINATION --}}
        <div class="mt-8">

            {{ $bookings->links() }}

        </div>

    </div>

</div>

@endsection