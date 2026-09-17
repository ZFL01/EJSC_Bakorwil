@extends('layouts.app')

@section('content')

@php
    use Carbon\Carbon;

    /*
    |--------------------------------------------------------------------------
    | Setup Awal
    |--------------------------------------------------------------------------
    */

    Carbon::setLocale('id');

    $openingTime = '08:00';
    $closingTime = '16:00';

    // Validasi tanggal
    try {
        $dateObject = Carbon::parse($selectedDate)->startOfDay();
    } catch (\Exception $e) {
        $dateObject = Carbon::today();
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: Konversi "HH:MM" ke menit (untuk perbandingan akurat)
    |--------------------------------------------------------------------------
    */

    $toMinutes = function (string $time): int {
        [$h, $m] = explode(':', $time);
        return ((int) $h) * 60 + (int) $m;
    };

    $toTime = function (int $minutes): string {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    };

    /*
    |--------------------------------------------------------------------------
    | Filter Booking Aktif + Normalisasi Waktu
    |--------------------------------------------------------------------------
    */

    $activeBookings = $bookings
        ->filter(fn ($b) => in_array($b->status, ['menunggu', 'disetujui']))
        ->map(function ($b) use ($toMinutes, $openingTime, $closingTime) {
            $start = Carbon::parse($b->time_start)->format('H:i');
            $end   = Carbon::parse($b->time_end)->format('H:i');

            // Clamp ke jam operasional
            $startMin = max($toMinutes($start), $toMinutes($openingTime));
            $endMin   = min($toMinutes($end),   $toMinutes($closingTime));

            return [
                'booking'    => $b,
                'startMin'   => $startMin,
                'endMin'     => $endMin,
            ];
        })
        ->filter(fn ($item) => $item['endMin'] > $item['startMin']) // buang yang invalid
        ->sortBy('startMin')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Susun Timeline (Merge Overlap)
    |--------------------------------------------------------------------------
    */

    $scheduleItems = [];
    $cursor = $toMinutes($openingTime);
    $closingMin = $toMinutes($closingTime);

    foreach ($activeBookings as $item) {
        $bStart = $item['startMin'];
        $bEnd   = $item['endMin'];

        // Lewati booking yang sudah "ketelan" oleh booking sebelumnya
        if ($bEnd <= $cursor) {
            continue;
        }

        // Jika booking mulai sebelum cursor (overlap), majukan start-nya
        if ($bStart < $cursor) {
            $bStart = $cursor;
        }

        // Slot kosong sebelum booking
        if ($cursor < $bStart) {
            $scheduleItems[] = [
                'type'    => 'available',
                'start'   => $toTime($cursor),
                'end'     => $toTime($bStart),
                'booking' => null,
            ];
        }

        // Slot booking
        $scheduleItems[] = [
            'type'    => 'booking',
            'start'   => $toTime($bStart),
            'end'     => $toTime($bEnd),
            'booking' => $item['booking'],
        ];

        $cursor = $bEnd;
    }

    // Sisa waktu sampai closing
    if ($cursor < $closingMin) {
        $scheduleItems[] = [
            'type'    => 'available',
            'start'   => $toTime($cursor),
            'end'     => $toTime($closingMin),
            'booking' => null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Data Kalender
    |--------------------------------------------------------------------------
    */

    $selected       = $dateObject->copy();
    $monthStart     = $selected->copy()->startOfMonth();
    $daysInMonth    = $monthStart->daysInMonth;
    $startDayOfWeek = ($monthStart->dayOfWeek + 6) % 7; // Senin = 0

    $monthIndo = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $dayIndo   = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
@endphp


<div class="min-h-screen bg-[#f8fbfc] py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- BREADCRUMB --}}
        <nav class="text-xs text-gray-500 mb-5" data-anim="fade-down">
            <a href="{{ url('/') }}" class="hover:text-[#0e4f81] transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('booking.index') }}" class="hover:text-[#0e4f81] transition-colors">Booking Ruangan</a>
            <span class="mx-2">/</span>
            <span class="text-[#0e4f81] font-medium">Ketersediaan Jadwal</span>
        </nav>

        {{-- HEADER --}}
        <div class="mb-8" data-anim="fade-down">
            <h1 class="text-3xl md:text-4xl font-bold text-[#0e4f81]">Ketersediaan Jadwal</h1>
            <p class="text-gray-600 mt-2">Pilih tanggal untuk melihat ketersediaan jadwal ruangan.</p>
        </div>

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5" data-anim="fade">
                <div class="font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-2.99l-6.93-12a2 2 0 00-3.48 0l-6.93 12A2 2 0 005.07 19z"/>
                    </svg>
                    Booking tidak dapat diproses:
                </div>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- LEGEND --}}
        <div class="flex flex-wrap items-center gap-5 mb-5 text-sm" data-anim="fade">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-500 legend-dot"></span>
                <span class="text-gray-600">Tersedia</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-yellow-500 legend-dot"></span>
                <span class="text-gray-600">Menunggu Persetujuan</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-500 legend-dot"></span>
                <span class="text-gray-600">Sudah Dibooking</span>
            </div>
        </div>

        {{-- MAIN LAYOUT --}}
        <div class="grid lg:grid-cols-5 gap-5 mb-6">

            {{-- CALENDAR --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6"
                 data-anim="fade-up">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-[#eef9fb] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0e4f81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-[#0e4f81]">{{ $room->name }}</div>
                        <div class="text-xs text-gray-500">Ketersediaan</div>
                    </div>
                </div>

                {{-- ROOM SELECTOR --}}
                <div class="mb-5">
                    <select id="roomSelector"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2] transition-all duration-200 cursor-pointer">
                        @foreach($rooms as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $room->id ? 'selected' : '' }}>
                                {{ $item->name }} — {{ $item->capacity }} orang
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NAVIGASI BULAN --}}
                <div class="mb-4 flex items-center justify-between">
                    <div class="font-semibold text-gray-700 text-sm">
                        {{ $monthIndo[$selected->month - 1] }} {{ $selected->year }}
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="changeMonth(-1)"
                            class="w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button type="button" onclick="changeMonth(1)"
                            class="w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- HARI --}}
                <div class="grid grid-cols-7 gap-1 mb-2 text-center">
                    @foreach($dayIndo as $d)
                        <div class="text-[10px] font-bold text-gray-400 uppercase py-1">{{ $d }}</div>
                    @endforeach
                </div>

                {{-- TANGGAL --}}
                <div class="grid grid-cols-7 gap-1">
                    @for($i = 0; $i < $startDayOfWeek; $i++)
                        <div></div>
                    @endfor

                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $dateStr    = $selected->copy()->day($day)->format('Y-m-d');
                            $isSelected = $day == $selected->day;
                            $dayDate    = $selected->copy()->day($day);
                            $isPast     = $dayDate->isPast() && !$dayDate->isToday();
                            $isToday    = $dayDate->isToday();
                        @endphp

                        <a href="{{ route('booking.schedule', ['room_id' => $room->id, 'date' => $dateStr]) }}"
                           class="aspect-square flex items-center justify-center rounded-lg text-xs font-medium transition-all duration-200
                                  {{ $isPast ? 'text-gray-300 cursor-not-allowed pointer-events-none' : '' }}
                                  {{ $isSelected ? 'bg-[#56b8c2] text-white shadow-md shadow-[#56b8c2]/30 scale-105' : '' }}
                                  {{ !$isSelected && !$isPast ? 'text-gray-700 hover:bg-[#eef9fb] hover:scale-105' : '' }}
                                  {{ $isToday && !$isSelected ? 'ring-1 ring-[#56b8c2]/40' : '' }}">
                            {{ $day }}
                        </a>
                    @endfor
                </div>

            </div>

            {{-- JADWAL --}}
            <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-200 shadow-sm p-6"
                 data-anim="fade-up" data-delay="100">

                <div class="mb-5">
                    <div class="text-xs text-gray-500 uppercase tracking-wide">Jadwal Tanggal</div>
                    <div class="font-bold text-[#0e4f81] text-lg mt-0.5">
                        {{ $dateObject->translatedFormat('d F Y') }}
                    </div>
                </div>

                <div class="space-y-3">

                    @forelse($scheduleItems as $index => $item)

                        @if($item['type'] === 'available')

                            {{-- SLOT TERSEDIA --}}
                            <div class="slot-item border border-green-200 bg-green-50/60 rounded-xl p-4 hover:border-green-300 hover:shadow-sm transition-all duration-200"
                                 data-anim="fade-up" data-delay="{{ $index * 40 }}">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">
                                                {{ $item['start'] }} - {{ $item['end'] }}
                                            </div>
                                            <div class="inline-flex items-center gap-1.5 text-xs text-green-600 font-medium mt-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Tersedia
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button"
                                        onclick="selectTime('{{ $item['start'] }}', '{{ $item['end'] }}')"
                                        class="inline-flex items-center justify-center gap-1.5 bg-[#56b8c2] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#45aab5] hover:shadow-lg hover:shadow-[#56b8c2]/30 active:scale-[0.98] transition-all duration-200">
                                        Booking
                                    </button>
                                </div>
                            </div>

                        @else

                            @php
                                $booking    = $item['booking'];
                                $isWaiting  = $booking->status === 'menunggu';
                                $isApproved = $booking->status === 'disetujui';
                                $bookingStart = $item['start'];
                                $bookingEnd   = $item['end'];
                            @endphp

                            @if($isWaiting)

                                {{-- MENUNGGU --}}
                                <a href="{{ route('booking.detail', $booking->id) }}"
                                   class="slot-item block border border-yellow-200 bg-yellow-50/60 rounded-xl p-4 hover:border-yellow-300 hover:shadow-sm transition-all duration-200"
                                   data-anim="fade-up" data-delay="{{ $index * 40 }}">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800">
                                                    {{ $bookingStart }} - {{ $bookingEnd }}
                                                </div>
                                                <div class="inline-flex items-center gap-1.5 text-xs text-yellow-600 font-medium mt-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                                    Menunggu Persetujuan
                                                </div>
                                                <div class="text-xs text-gray-500 mt-2 space-y-0.5">
                                                    <div>Pengajuan: <span class="text-gray-700 font-medium">{{ $booking->name }}</span></div>
                                                    <div>Instansi: <span class="text-gray-700 font-medium">{{ $booking->institution }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-sm font-semibold text-yellow-600 whitespace-nowrap self-end sm:self-center">
                                            Lihat Detail →
                                        </div>
                                    </div>
                                </a>

                            @elseif($isApproved)

                                {{-- SUDAH DIBOOKING --}}
                                <a href="{{ route('booking.detail', $booking->id) }}"
                                   class="slot-item block border border-red-200 bg-red-50/60 rounded-xl p-4 hover:border-red-300 hover:shadow-sm transition-all duration-200"
                                   data-anim="fade-up" data-delay="{{ $index * 40 }}">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800">
                                                    {{ $bookingStart }} - {{ $bookingEnd }}
                                                </div>
                                                <div class="inline-flex items-center gap-1.5 text-xs text-red-600 font-medium mt-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Sudah Dibooking
                                                </div>
                                                <div class="text-xs text-gray-500 mt-2 space-y-0.5">
                                                    <div>Pembooking: <span class="text-gray-700 font-medium">{{ $booking->name }}</span></div>
                                                    <div>Instansi: <span class="text-gray-700 font-medium">{{ $booking->institution }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-sm font-semibold text-red-500 whitespace-nowrap self-end sm:self-center">
                                            Lihat Detail →
                                        </div>
                                    </div>
                                </a>

                            @endif

                        @endif

                    @empty

                        {{-- KOSONG TOTAL --}}
                        <div class="slot-item border border-green-200 bg-green-50/60 rounded-xl p-4"
                             data-anim="fade-up">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">08:00 - 16:00</div>
                                        <div class="inline-flex items-center gap-1.5 text-xs text-green-600 font-medium mt-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Tersedia
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="selectTime('08:00', '16:00')"
                                    class="inline-flex items-center justify-center gap-1.5 bg-[#56b8c2] text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-[#45aab5] hover:shadow-lg hover:shadow-[#56b8c2]/30 active:scale-[0.98] transition-all duration-200">
                                    Booking
                                </button>
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        {{-- INFO --}}
        <div class="bg-[#eef9fb] border border-[#d9f0f3] rounded-2xl p-5" data-anim="fade-up">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg bg-white flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#0e4f81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {{-- Path sudah diperbaiki --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-[#0e4f81]">Informasi Jadwal</h4>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                        Jadwal booking mengikuti waktu penggunaan yang diajukan.
                        Jam operasional EJSC adalah pukul <strong>08.00–16.00</strong>.
                        Klik jadwal yang sudah dibooking atau masih menunggu persetujuan untuk melihat detail booking.
                    </p>
                </div>
            </div>
        </div>

        {{-- FORM BOOKING --}}
        <div id="bookingForm" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8 mt-6"
             data-anim="fade-up">

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#0e4f81]">Ajukan Booking Ruangan</h2>
                <p class="text-sm text-gray-500 mt-1">Lengkapi data berikut untuk mengajukan booking.</p>
            </div>

            <form action="{{ route('booking.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- RUANGAN --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ruangan</label>
                    <input type="text" value="{{ $room->name }}" readonly
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                </div>

                {{-- TANGGAL --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Booking</label>
                    <input type="date" id="bookingDate" name="booking_date"
                           value="{{ old('booking_date', $selectedDate) }}"
                           min="{{ now()->format('Y-m-d') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                </div>

                {{-- JAM --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                        <input type="time" id="startTime" name="start_time" value="{{ old('start_time') }}"
                               min="08:00" max="15:59" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                        <input type="time" id="endTime" name="end_time" value="{{ old('end_time') }}"
                               min="08:01" max="16:00" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                    </div>
                </div>

                {{-- NAMA --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pembooking</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Masukkan nama pembooking" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                </div>

                {{-- INSTANSI --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instansi</label>
                    <input type="text" name="institution" value="{{ old('institution') }}"
                           placeholder="Masukkan nama instansi" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                </div>

                {{-- WHATSAPP --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                           placeholder="Contoh: 081234567890" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                </div>

                {{-- PESERTA --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Peserta</label>
                    <input type="number" name="participant_count" value="{{ old('participant_count') }}"
                           min="1" max="{{ $room->capacity }}"
                           placeholder="Maksimal {{ $room->capacity }} orang" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">
                    <p class="text-xs text-gray-500 mt-1">Kapasitas {{ $room->name }} maksimal {{ $room->capacity }} orang.</p>
                </div>

                {{-- TUJUAN --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tujuan Penggunaan</label>
                    <textarea name="purpose" rows="4" placeholder="Jelaskan tujuan penggunaan ruangan" required
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]/30 focus:border-[#56b8c2]">{{ old('purpose') }}</textarea>
                </div>

                {{-- FASILITAS --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Fasilitas Tambahan</label>
                    @php
                        $facilities = ['Proyektor', 'Sound System', 'Microphone', 'Meja Tambahan'];
                    @endphp
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($facilities as $facility)
                            <label class="flex items-center gap-3 border border-gray-200 rounded-xl px-4 py-3 cursor-pointer hover:bg-gray-50 transition">
                                <input type="checkbox" name="additional_facilities[]" value="{{ $facility }}"
                                       {{ in_array($facility, old('additional_facilities', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-gray-300 text-[#56b8c2] focus:ring-[#56b8c2]">
                                <span class="text-sm text-gray-700">{{ $facility }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-3">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 bg-[#56b8c2] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#45aab5] hover:shadow-lg hover:shadow-[#56b8c2]/30 active:scale-[0.99] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
                        </svg>
                        Ajukan Booking
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>


{{-- ============================================================
     STYLE ANIMASI (halus, tidak norak)
     ============================================================ --}}
<style>
    /* Animasi masuk — natural, bukan template AI */
    [data-anim] {
        opacity: 0;
        animation: animIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    [data-anim="fade-down"] { transform: translateY(-8px); }
    [data-anim="fade-up"]   { transform: translateY(10px); }
    [data-anim="fade"]      { transform: none; }

    @keyframes animIn {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Delay bertingkat via atribut data-delay */
    [data-delay="40"]   { animation-delay: 0.04s; }
    [data-delay="80"]   { animation-delay: 0.08s; }
    [data-delay="120"]  { animation-delay: 0.12s; }
    [data-delay="160"]  { animation-delay: 0.16s; }
    [data-delay="200"]  { animation-delay: 0.20s; }
    [data-delay="240"]  { animation-delay: 0.24s; }
    [data-delay="280"]  { animation-delay: 0.28s; }
    [data-delay="320"]  { animation-delay: 0.32s; }
    [data-delay="360"]  { animation-delay: 0.36s; }
    [data-delay="400"]  { animation-delay: 0.40s; }

    /* Dot legend berdenyut halus */
    .legend-dot {
        animation: pulseDot 2.4s ease-in-out infinite;
    }
    .legend-dot:nth-child(1) { animation-delay: 0s; }
    .legend-dot:nth-child(2) { animation-delay: 0.4s; }
    .legend-dot:nth-child(3) { animation-delay: 0.8s; }

    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.25); opacity: 0.75; }
    }

    /* Slot hover — lift halus */
    .slot-item {
        will-change: transform, box-shadow;
    }
    .slot-item:hover {
        transform: translateY(-2px);
    }

    /* Hormati preferensi user */
    @media (prefers-reduced-motion: reduce) {
        [data-anim] { animation: none; opacity: 1; }
        .legend-dot { animation: none; }
        .slot-item:hover { transform: none; }
    }
</style>


<script>
/*
|--------------------------------------------------------------------------
| Pilih Waktu Booking
|--------------------------------------------------------------------------
*/
function selectTime(startTime, endTime) {
    const startInput = document.getElementById('startTime');
    const endInput   = document.getElementById('endTime');
    const form       = document.getElementById('bookingForm');

    if (startInput) startInput.value = startTime;
    if (endInput)   endInput.value   = endTime;

    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        // Highlight halus biar user sadar form-nya terisi
        form.style.transition = 'box-shadow .4s ease';
        form.style.boxShadow = '0 0 0 3px rgba(86,184,194,.35)';
        setTimeout(() => { form.style.boxShadow = ''; }, 1200);
    }
}

/*
|--------------------------------------------------------------------------
| Ganti Ruangan
|--------------------------------------------------------------------------
*/
const roomSelector = document.getElementById('roomSelector');
if (roomSelector) {
    roomSelector.addEventListener('change', function () {
        const roomId = this.value;
        const date   = "{{ $selectedDate }}";
        const url    = "{{ route('booking.schedule') }}";
        window.location.href = url + "?room_id=" + encodeURIComponent(roomId) + "&date=" + encodeURIComponent(date);
    });
}

/*
|--------------------------------------------------------------------------
| Ganti Bulan (FIXED: tidak auto-roll tanggal 31)
|--------------------------------------------------------------------------
*/
function changeMonth(direction) {
    const baseDate = new Date("{{ $selectedDate }}");
    const targetYear  = baseDate.getFullYear();
    const targetMonth = baseDate.getMonth() + direction;

    // Selalu pakai tanggal 1 dulu, baru clamp ke tanggal valid di bulan tujuan
    const firstOfTarget = new Date(targetYear, targetMonth, 1);

    const year  = firstOfTarget.getFullYear();
    const month = String(firstOfTarget.getMonth() + 1).padStart(2, '0');
    const day   = '01';

    const url = "{{ route('booking.schedule') }}";
    window.location.href = url + "?room_id={{ $room->id }}" + "&date=" + year + "-" + month + "-" + day;
}
</script>

@endsection