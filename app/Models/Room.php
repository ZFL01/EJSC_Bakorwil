<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'capacity',
        'facilities',
        'icon',
        'image',
        'is_active',
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}