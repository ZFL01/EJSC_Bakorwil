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

        return view('booking.index', compact('rooms'));
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

        return view(
            'booking.schedule',
            compact(
                'rooms',
                'room',
                'selectedDate',
                'bookings',
                'openingTime',
                'closingTime'
            )
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
                $validated['additional_facilities'] ?? [],

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