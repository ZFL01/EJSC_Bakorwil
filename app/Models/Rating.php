<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'client_id',
        'rateable_type',
        'rateable_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Relasi ke client yang memberikan rating.
     */
    public function client()
    {
        return $this->belongsTo(
            Client::class,
            'client_id',
            'id_client'
        );
    }

    /**
     * Relasi polymorphic ke Talent atau Mentor.
     */
    public function rateable()
    {
        return $this->morphTo();
    }
}