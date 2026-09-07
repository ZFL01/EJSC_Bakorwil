<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'id_wilayah';
    
    public $timestamps = false;

    protected $fillable = [
        'nama_wilayah',
        'jenis_wilayah',
        'bakorwil',
        'kode_bps',
        'geom',
    ];

    /**
     * Relasi ke users.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_wilayah', 'id_wilayah');
    }

    /**
     * Relasi ke mentors.
     */
    public function mentors()
    {
        return $this->hasMany(Mentor::class, 'id_wilayah', 'id_wilayah');
    }

    /**
     * Relasi ke talents.
     */
    public function talents()
    {
        return $this->hasMany(Talent::class, 'id_wilayah', 'id_wilayah');
    }

    /**
     * Relasi ke clients.
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'id_wilayah', 'id_wilayah');
    }
}
