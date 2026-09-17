<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    protected $table = 'bookings';

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
        'date' => 'date',
        'facilities' => 'array',
        'approved_at' => 'datetime',
    ];

    /**
     * Relasi ke ruangan
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id_user'
        );
    }
}