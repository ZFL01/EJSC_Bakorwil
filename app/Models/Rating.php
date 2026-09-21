<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'client_id',
        'admin_id',
        'rater_name',
        'rateable_type',
        'rateable_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(
            Client::class,
            'client_id',
            'id_client'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            User::class,
            'admin_id',
            'id_user'
        );
    }

    public function rateable()
    {
        return $this->morphTo();
    }
}