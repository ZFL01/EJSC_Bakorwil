<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'name',
        'institution',
        'whatsapp',
        'participants',
        'purpose',
        'facilities',
        'date',
        'time_start',
        'time_end',
        'status',
        'admin_note',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'facilities' => 'array',
        'date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: booking yang masih aktif (menunggu atau disetujui)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['menunggu', 'disetujui']);
    }

    /**
     * Cek apakah slot waktu tertentu sudah dibooking
     */
    public static function isSlotBooked($roomId, $date, $timeStart, $timeEnd)
    {
        return self::where('room_id', $roomId)
            ->where('date', $date)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($timeStart, $timeEnd) {
                $q->whereBetween('time_start', [$timeStart, $timeEnd])
                  ->orWhereBetween('time_end', [$timeStart, $timeEnd])
                  ->orWhere(function ($q2) use ($timeStart, $timeEnd) {
                      $q2->where('time_start', '<=', $timeStart)
                         ->where('time_end', '>=', $timeEnd);
                  });
            })
            ->exists();
    }
}