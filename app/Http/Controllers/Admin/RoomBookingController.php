<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomBookingController extends Controller
{
    /**
     * Halaman daftar booking
     */
    public function index(Request $request)
    {
        $query = RoomBooking::with('room')
            ->latest('created_at');

        /*
         * Pencarian
         */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'name',
                    'ILIKE',
                    "%{$search}%"
                )
                ->orWhere(
                    'institution',
                    'ILIKE',
                    "%{$search}%"
                )
                ->orWhere(
                    'whatsapp',
                    'ILIKE',
                    "%{$search}%"
                );
            });
        }

        /*
         * Filter ruangan
         */
        if ($request->filled('room_id')) {
            $query->where(
                'room_id',
                $request->room_id
            );
        }

        /*
         * Filter status
         */
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
         * Filter tanggal
         */
        if ($request->filled('date')) {
            $query->whereDate(
                'date',
                $request->date
            );
        }

        /*
         * Pagination
         */
        $bookings = $query
            ->paginate(10)
            ->withQueryString();

        /*
         * Data ruangan untuk filter
         */
        $rooms = Room::where(
                'is_active',
                true
            )
            ->orderBy('name')
            ->get();

        return view(
            'admin.bookings.index',
            compact(
                'bookings',
                'rooms'
            )
        );
    }

    /**
     * Detail booking
     */
    public function show($id)
    {
        $booking = RoomBooking::with('room')
            ->findOrFail($id);

        return view(
            'admin.bookings.show',
            compact('booking')
        );
    }

    /**
     * Menyetujui booking
     */
    public function approve($id)
    {
        $booking = RoomBooking::findOrFail($id);

        /*
         * Hanya booking menunggu
         * yang dapat disetujui.
         */
        if ($booking->status !== 'menunggu') {
            return back()->with(
                'error',
                'Booking ini tidak dapat disetujui karena statusnya bukan menunggu.'
            );
        }

        /*
         * Cek bentrok dengan booking lain
         */
        $conflict = RoomBooking::where(
                'room_id',
                $booking->room_id
            )
            ->where(
                'id',
                '!=',
                $booking->id
            )
            ->whereDate(
                'date',
                $booking->date
            )
            ->whereIn('status', [
                'menunggu',
                'disetujui',
            ])
            ->where(
                'time_start',
                '<',
                $booking->time_end
            )
            ->where(
                'time_end',
                '>',
                $booking->time_start
            )
            ->exists();

        /*
         * Jika jadwal bentrok
         */
        if ($conflict) {
            return back()->with(
                'error',
                'Booking tidak dapat disetujui karena jadwal tersebut bentrok dengan booking lain.'
            );
        }

        /*
         * Setujui
         */
        $booking->update([
            'status' => 'disetujui',

            'approved_at' => now(),

            'approved_by' => Auth::check()
                ? Auth::user()->id_user
                : null,
        ]);

        return back()->with(
            'success',
            'Booking berhasil disetujui.'
        );
    }

    /**
     * Menolak booking
     */
    public function reject(
        Request $request,
        $id
    ) {
        $booking = RoomBooking::findOrFail($id);

        /*
         * Hanya booking menunggu
         * yang dapat ditolak.
         */
        if ($booking->status !== 'menunggu') {
            return back()->with(
                'error',
                'Booking ini tidak dapat ditolak karena statusnya bukan menunggu.'
            );
        }

        /*
         * Simpan status ditolak
         */
        $booking->update([
            'status' => 'ditolak',

            'admin_note' =>
                $request->admin_note,
        ]);

        return back()->with(
            'success',
            'Booking berhasil ditolak.'
        );
    }

    /**
     * Membatalkan booking
     */
    public function cancel(
        Request $request,
        $id
    ) {
        $booking = RoomBooking::findOrFail($id);

        /*
         * Booking yang boleh dibatalkan:
         * - menunggu
         * - disetujui
         */
        if (
            !in_array(
                $booking->status,
                [
                    'menunggu',
                    'disetujui',
                ]
            )
        ) {
            return back()->with(
                'error',
                'Booking ini tidak dapat dibatalkan.'
            );
        }

        /*
         * Simpan status dibatalkan
         */
        $booking->update([
            'status' => 'dibatalkan',

            'admin_note' =>
                $request->admin_note,
        ]);

        return back()->with(
            'success',
            'Booking berhasil dibatalkan.'
        );
    }

    /**
     * Menandai booking selesai
     */
    public function complete($id)
    {
        $booking = RoomBooking::findOrFail($id);

        /*
         * Hanya booking disetujui
         * yang dapat diselesaikan.
         */
        if ($booking->status !== 'disetujui') {
            return back()->with(
                'error',
                'Hanya booking yang sudah disetujui yang dapat ditandai selesai.'
            );
        }

        /*
         * Simpan status selesai
         */
        $booking->update([
            'status' => 'selesai',
        ]);

        return back()->with(
            'success',
            'Booking berhasil ditandai sebagai selesai.'
        );
    }
}