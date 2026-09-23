<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomBookingController extends Controller
{
    /**
     * Halaman utama booking ruangan
     */
    public function index()
    {
        $rooms = Room::where('is_active', true)
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Jam operasional EJSC
        |--------------------------------------------------------------------------
        */

        $openingTime = '08:00';
        $closingTime = '16:00';

        /*
        |--------------------------------------------------------------------------
        | Preview jadwal HARI INI (data asli, bukan contoh)
        |--------------------------------------------------------------------------
        |
        | Hanya jadwal tanggal hari ini (hari H) untuk ruangan pertama yang
        | ditampilkan pada ilustrasi halaman daftar ruangan.
        |
        */

        $today = now()->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Ruangan untuk preview
        |--------------------------------------------------------------------------
        |
        | Utamakan ruangan yang punya jadwal pada hari ini supaya ilustrasi
        | menampilkan aktivitas nyata. Jika semua ruangan kosong, pakai
        | ruangan pertama.
        |
        */

        $roomIdsWithBooking = RoomBooking::whereDate(
                'date',
                $today
            )
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->pluck('room_id')
            ->unique();

        $previewRoom = $rooms->first(
            fn (Room $room) => $roomIdsWithBooking->contains($room->id)
        ) ?: $rooms->first();

        $previewSlots = $previewRoom
            ? $this->buildDaySlots($previewRoom, $today)
            : [];

        /*
        |--------------------------------------------------------------------------
        | Jadwal hari ini untuk SEMUA ruangan
        |--------------------------------------------------------------------------
        |
        | Dipakai tombol pemilih ruangan di bawah kartu ilustrasi, supaya
        | pengunjung bisa cek jadwal tiap ruangan pada hari yang sama tanpa
        | pindah halaman.
        |
        */

        $todaySlots = $rooms->mapWithKeys(
            fn (Room $room) => [$room->id => $this->buildDaySlots($room, $today)]
        );

        return view(
            'booking.index',
            compact(
                'rooms',
                'previewRoom',
                'previewSlots',
                'todaySlots',
                'today',
                'openingTime',
                'closingTime'
            )
        );
    }

    /**
     * Halaman ketersediaan jadwal
     *
     * Jam operasional EJSC:
     * 08:00 - 16:00
     */
    public function schedule(Request $request)
    {
        $rooms = Room::where('is_active', true)
            ->orderBy('id')
            ->get();

        if ($rooms->isEmpty()) {
            abort(404, 'Belum ada ruangan yang tersedia.');
        }

        /*
        |--------------------------------------------------------------------------
        | Ruangan yang dipilih
        |--------------------------------------------------------------------------
        */

        $roomId = $request->room_id ?? $rooms->first()->id;

        $room = Room::where('is_active', true)
            ->findOrFail($roomId);

        /*
        |--------------------------------------------------------------------------
        | Tanggal yang dipilih
        |--------------------------------------------------------------------------
        */

        $selectedDate = $request->date
            ?? now()->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Ambil booking aktif
        |--------------------------------------------------------------------------
        |
        | Hanya:
        | - menunggu
        | - disetujui
        |
        | Yang ditolak, selesai, dan dibatalkan
        | tidak mengunci jadwal.
        |
        */

        $bookings = RoomBooking::where(
                'room_id',
                $room->id
            )
            ->whereDate(
                'date',
                $selectedDate
            )
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->orderBy('time_start')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Jam operasional EJSC
        |--------------------------------------------------------------------------
        */

        $openingTime = '08:00';
        $closingTime = '16:00';

        /*
        |--------------------------------------------------------------------------
        | Slot jadwal (data asli dari database)
        |--------------------------------------------------------------------------
        |
        | Logika penggabungan slot hanya ada di buildDaySlots() supaya halaman
        | jadwal dan preview jadwal hari ini memakai sumber data yang sama.
        |
        */

        $scheduleItems = $this->buildDaySlots(
            $room,
            $selectedDate
        );

        return view(
            'booking.schedule',
            compact(
                'rooms',
                'room',
                'selectedDate',
                'bookings',
                'scheduleItems',
                'openingTime',
                'closingTime'
            )
        );
    }

    /**
     * Susun slot jadwal satu ruangan pada tanggal tertentu.
     *
     * Sumber data: tabel `bookings` dengan status menunggu & disetujui saja.
     * Hasilnya berupa timeline:
     * - type "available" : slot kosong yang bisa dibooking
     * - type "booking"   : slot yang sudah terpakai
     *
     * Dipakai bersama oleh halaman jadwal dan preview jadwal hari ini pada
     * halaman daftar ruangan, sehingga tidak ada data contoh (dummy).
     */
    private function buildDaySlots(Room $room, string $date): array
    {
        $openingMinutes = $this->timeToMinutes('08:00');
        $closingMinutes = $this->timeToMinutes('16:00');

        $activeBookings = RoomBooking::where(
                'room_id',
                $room->id
            )
            ->whereDate(
                'date',
                $date
            )
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->orderBy('time_start')
            ->get()
            ->map(function (RoomBooking $booking) use ($openingMinutes, $closingMinutes) {
                /*
                |----------------------------------------------------------------------
                | Clamp ke jam operasional agar slot tetap valid
                |----------------------------------------------------------------------
                */

                $bookingStart = max(
                    $this->timeToMinutes($booking->time_start),
                    $openingMinutes
                );

                $bookingEnd = min(
                    $this->timeToMinutes($booking->time_end),
                    $closingMinutes
                );

                return [
                    'booking' => $booking,
                    'startMinutes' => $bookingStart,
                    'endMinutes' => $bookingEnd,
                ];
            })
            ->filter(
                fn (array $item) => $item['endMinutes'] > $item['startMinutes']
            )
            ->sortBy('startMinutes')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Gabungkan booking yang beririsan menjadi timeline
        |--------------------------------------------------------------------------
        */

        $scheduleItems = [];
        $cursor = $openingMinutes;

        foreach ($activeBookings as $item) {
            $bookingStart = $item['startMinutes'];
            $bookingEnd = $item['endMinutes'];

            // Booking yang sudah "ketelan" booking sebelumnya
            if ($bookingEnd <= $cursor) {
                continue;
            }

            if ($bookingStart < $cursor) {
                $bookingStart = $cursor;
            }

            // Slot kosong sebelum booking
            if ($cursor < $bookingStart) {
                $scheduleItems[] = [
                    'type' => 'available',
                    'start' => $this->minutesToTime($cursor),
                    'end' => $this->minutesToTime($bookingStart),
                    'booking' => null,
                ];
            }

            // Slot yang terpakai
            $scheduleItems[] = [
                'type' => 'booking',
                'start' => $this->minutesToTime($bookingStart),
                'end' => $this->minutesToTime($bookingEnd),
                'booking' => $item['booking'],
            ];

            $cursor = $bookingEnd;
        }

        // Sisa waktu sampai jam tutup
        if ($cursor < $closingMinutes) {
            $scheduleItems[] = [
                'type' => 'available',
                'start' => $this->minutesToTime($cursor),
                'end' => $this->minutesToTime($closingMinutes),
                'booking' => null,
            ];
        }

        return $scheduleItems;
    }

    /**
     * Konversi jam "HH:MM" (boleh "HH:MM:SS") menjadi jumlah menit.
     */
    private function timeToMinutes(string $time): int
    {
        [$hour, $minute] = explode(':', substr($time, 0, 5));

        return ((int) $hour * 60) + (int) $minute;
    }

    /**
     * Konversi jumlah menit menjadi jam "HH:MM".
     */
    private function minutesToTime(int $minutes): string
    {
        return sprintf(
            '%02d:%02d',
            intdiv($minutes, 60),
            $minutes % 60
        );
    }

    /**
     * Simpan pengajuan booking
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'institution' => [
                'required',
                'string',
                'max:255',
            ],

            'whatsapp' => [
                'required',
                'string',
                'max:30',
            ],

            'participant_count' => [
                'required',
                'integer',
                'min:1',
            ],

            'purpose' => [
                'required',
                'string',
            ],

            'additional_facilities' => [
                'nullable',
                'array',
            ],

            'additional_facilities.*' => [
                'string',
                'max:100',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jam operasional EJSC
        |--------------------------------------------------------------------------
        |
        | Buka  : 08:00
        | Tutup : 16:00
        |
        */

        $openingTime = '08:00';
        $closingTime = '16:00';

        /*
        |--------------------------------------------------------------------------
        | Cek jam operasional
        |--------------------------------------------------------------------------
        */

        if (
            $validated['start_time'] < $openingTime ||
            $validated['end_time'] > $closingTime
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'Booking hanya dapat dilakukan pada jam operasional EJSC, yaitu 08.00–16.00.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek jam mulai dan selesai
        |--------------------------------------------------------------------------
        */

        if (
            $validated['start_time'] >=
            $validated['end_time']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'Jam selesai harus lebih besar dari jam mulai.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil ruangan
        |--------------------------------------------------------------------------
        */

        $room = Room::where(
                'is_active',
                true
            )
            ->findOrFail(
                $validated['room_id']
            );

        /*
        |--------------------------------------------------------------------------
        | Cek kapasitas
        |--------------------------------------------------------------------------
        */

        if (
            $validated['participant_count'] >
            $room->capacity
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'participant_count' =>
                        "Jumlah peserta melebihi kapasitas {$room->capacity} orang."
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek bentrok jadwal
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Booking lama : 10:00 - 12:00
        | Booking baru : 11:00 - 13:00
        |
        | Tidak diperbolehkan.
        |
        | Tetapi:
        |
        | Booking lama : 10:00 - 12:00
        | Booking baru : 12:00 - 14:00
        |
        | Diperbolehkan.
        |
        */

        $conflict = RoomBooking::where(
                'room_id',
                $validated['room_id']
            )
            ->whereDate(
                'date',
                $validated['booking_date']
            )
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->where(
                'time_start',
                '<',
                $validated['end_time']
            )
            ->where(
                'time_end',
                '>',
                $validated['start_time']
            )
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'Jadwal tersebut sudah digunakan. Silakan pilih waktu lain.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan booking
        |--------------------------------------------------------------------------
        */

        $booking = RoomBooking::create([
            'room_id' =>
                $validated['room_id'],

            'user_id' =>
                Auth::check()
                    ? Auth::user()->id_user
                    : null,

            'name' =>
                $validated['name'],

            'institution' =>
                $validated['institution'],

            'whatsapp' =>
                $validated['whatsapp'],

            'participants' =>
                $validated['participant_count'],

            'purpose' =>
                $validated['purpose'],

            'facilities' =>
                array_values(
                    array_filter(
                        $validated['additional_facilities'] ?? []
                    )
                ),

            'date' =>
                $validated['booking_date'],

            'time_start' =>
                $validated['start_time'],

            'time_end' =>
                $validated['end_time'],

            /*
            |--------------------------------------------------------------------------
            | Status awal
            |--------------------------------------------------------------------------
            */

            'status' => 'menunggu',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Setelah booking berhasil
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'booking.success',
                $booking->id
            );
    }

    /**
     * Halaman booking berhasil
     *
     * Halaman ini juga digunakan untuk menampilkan
     * detail booking setelah booking dibuat.
     */
    public function success($id)
    {
        $booking = RoomBooking::with('room')
            ->findOrFail($id);

        return view(
            'booking.success',
            compact('booking')
        );
    }

    /**
     * Detail booking dari halaman jadwal
     *
     * Tidak membuat detail.blade.php.
     *
     * Detail langsung menggunakan:
     * booking.success
     *
     * Hanya booking dengan status:
     * - menunggu
     * - disetujui
     *
     * yang bisa dibuka dari jadwal.
     */
    public function detail($id)
    {
        $booking = RoomBooking::with('room')
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->findOrFail($id);

        return view(
            'booking.success',
            compact('booking')
        );
    }

    /**
     * Booking saya
     */
    public function myBookings()
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $bookings = RoomBooking::with('room')
            ->where(
                'user_id',
                Auth::user()->id_user
            )
            ->latest()
            ->paginate(10);

        return view(
            'booking.my-bookings',
            compact('bookings')
        );
    }
}