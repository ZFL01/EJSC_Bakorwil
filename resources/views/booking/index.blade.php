@extends('layouts.app')

@section('content')

<div class="bg-white min-h-screen overflow-x-hidden">

    {{-- HERO --}}
    <section class="relative bg-gradient-to-b from-[#eef9fb] via-[#f8fbfc] to-white pt-6 pb-16 overflow-hidden">

        {{-- Dekorasi halus --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#56b8c2]/10 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-[#0e4f81]/5 rounded-full blur-3xl animate-float-slower"></div>

        {{-- Grid pattern subtle --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #0e4f81 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative max-w-7xl mx-auto px-6">

            {{-- Breadcrumb --}}
            <nav class="text-xs text-gray-500 mb-6 animate-fade-in-up">
                <a href="{{ url('/') }}" class="hover:text-[#0e4f81] transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <span class="text-[#0e4f81] font-medium">Booking Ruangan</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <div>
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight text-[#0e4f81] animate-fade-in-up" style="animation-delay: 0.05s;">
                        Booking
                    </h1>
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight text-[#56b8c2] relative inline-block animate-fade-in-up" style="animation-delay: 0.1s;">
                        Ruangan
                        <svg class="absolute -bottom-2 left-0 w-full h-3" viewBox="0 0 200 12" preserveAspectRatio="none" fill="none">
                            <path d="M2 9C50 3 150 3 198 9" stroke="#56b8c2" stroke-width="2.5" stroke-linecap="round" opacity="0.4"/>
                        </svg>
                    </h1>

                    <p class="mt-8 text-gray-600 text-lg leading-relaxed max-w-lg animate-fade-in-up" style="animation-delay: 0.2s;">
                        Temukan dan pesan ruangan yang sesuai dengan
                        kebutuhan kegiatan Anda di EJSC Bakorwil Jember.
                    </p>

                    {{-- Stats kecil --}}
                    <div class="mt-8 flex flex-wrap items-center gap-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-[#eef9fb] flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#0e4f81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-[#0e4f81]">{{ $rooms->count() }} Ruangan</div>
                                <div class="text-xs text-gray-500">Tersedia</div>
                            </div>
                        </div>

                        <div class="w-px h-10 bg-gray-200"></div>

                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-[#eef9fb] flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#0e4f81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-[#0e4f81]">08.00 - 16.00</div>
                                <div class="text-xs text-gray-500">Jam Operasional</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ilustrasi --}}
                <div class="hidden lg:flex justify-end">
                    <div class="relative w-full max-w-md animate-fade-in-up" style="animation-delay: 0.25s;">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#56b8c2]/20 to-[#0e4f81]/10 rounded-full blur-3xl"></div>

                        {{-- Card utama dengan ilustrasi kalender/booking --}}
                        <div class="relative bg-white rounded-3xl p-6 shadow-xl shadow-[#0e4f81]/5 border border-gray-100">

                            {{-- Header window --}}
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                                <div class="ml-auto text-[10px] text-gray-400 font-mono">booking.ejsc.id</div>
                            </div>

                            {{-- Preview jadwal --}}
                            <div class="space-y-2.5">

                                {{-- Slot tersedia --}}
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-green-50/70 border border-green-100">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold text-gray-700">08:00 - 10:00</div>
                                        <div class="text-[10px] text-green-600">Tersedia</div>
                                    </div>
                                    <div class="text-[10px] font-semibold text-[#56b8c2]">Booking →</div>
                                </div>

                                {{-- Slot booking --}}
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-red-50/70 border border-red-100">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold text-gray-700">10:00 - 12:00</div>
                                        <div class="text-[10px] text-red-600">Sudah Dibooking</div>
                                    </div>
                                </div>

                                {{-- Slot tersedia --}}
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-green-50/70 border border-green-100">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <div class="flex-1">
                                        <div class="text-xs font-semibold text-gray-700">13:00 - 16:00</div>
                                        <div class="text-[10px] text-green-600">Tersedia</div>
                                    </div>
                                    <div class="text-[10px] font-semibold text-[#56b8c2]">Booking →</div>
                                </div>

                            </div>

                            {{-- Footer mini --}}
                            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div class="text-[10px] text-gray-400">Aula Utama</div>
                                <div class="flex gap-1">
                                    <div class="w-1 h-1 rounded-full bg-[#56b8c2]"></div>
                                    <div class="w-1 h-1 rounded-full bg-[#56b8c2]/50"></div>
                                    <div class="w-1 h-1 rounded-full bg-[#56b8c2]/25"></div>
                                </div>
                            </div>

                        </div>

                        {{-- Floating badge --}}
                        <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-3 shadow-lg shadow-[#0e4f81]/10 border border-gray-100 flex items-center gap-2.5 animate-float-slow">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#0e4f81] to-[#56b8c2] flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-[#0e4f81]">Konfirmasi</div>
                                <div class="text-[10px] text-gray-500">Cepat & Mudah</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>


    {{-- PILIH RUANGAN --}}
   <section class="py-16 -mt-6">

         <div class="max-w-7xl mx-auto px-6">

            <div class="mb-10 animate-fade-in-up">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-6 rounded-full bg-[#56b8c2]"></div>
                    <span class="text-xs font-semibold text-[#56b8c2] uppercase tracking-wider">Daftar Ruangan</span>
                </div>
                <h2 class="text-3xl font-bold text-[#0e4f81]">
                    Pilih Ruangan
                </h2>
                <p class="mt-2 text-gray-500 max-w-xl">
                    Pilih ruang yang sesuai dengan kebutuhan kegiatan Anda.
                </p>
            </div>


            <div class="grid md:grid-cols-2 gap-6">

                @foreach($rooms as $room)

                    <div class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-[#56b8c2] hover:shadow-xl hover:shadow-[#56b8c2]/10 hover:-translate-y-1 transition-all duration-300 animate-fade-in-up"
                         style="animation-delay: {{ 0.1 + ($loop->index * 0.1) }}s;">

                        {{-- Header Ruangan --}}
                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 rounded-xl bg-[#eef9fb] flex items-center justify-center flex-shrink-0 group-hover:bg-[#56b8c2]/15 group-hover:scale-105 transition-all duration-300">
                                <svg class="w-6 h-6 text-[#0e4f81] group-hover:text-[#56b8c2] transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-[#0e4f81] group-hover:text-[#56b8c2] transition-colors duration-300">
                                    {{ $room->name }}
                                </h3>
                                <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                                    {{ $room->description }}
                                </p>
                            </div>

                        </div>


                        {{-- Fasilitas --}}
                        <div class="mt-6 space-y-2.5">

                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                                </svg>
                                <span>Kapasitas: {{ $room->capacity }} orang</span>
                            </div>

                            @foreach(array_slice($room->facilities ?? [], 0, 4) as $facility)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-[#56b8c2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>{{ $facility }}</span>
                                </div>
                            @endforeach

                        </div>


                        {{-- Button --}}
                        <div class="mt-6">
                            <a
                                href="{{ route('booking.schedule', ['room_id' => $room->id]) }}"
                                class="w-full inline-flex items-center justify-center gap-2 bg-[#56b8c2] text-white font-semibold py-3 rounded-xl hover:bg-[#45aab5] hover:shadow-lg hover:shadow-[#56b8c2]/30 active:scale-[0.98] transition-all duration-200 group/btn">
                                <span>Lihat Jadwal</span>
                                <span class="transition-transform duration-200 group-hover/btn:translate-x-1">→</span>
                            </a>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

</div>


<style>
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

    @keyframes float-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes float-slower {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-14px);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }

    .animate-float-slower {
        animation: float-slower 8s ease-in-out infinite;
    }
</style>

@endsection