<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    protected $primaryKey = 'id_client';
    public $timestamps = true;

    protected $fillable = [
        'id_user', 'id_wilayah', 'nama_ukm', 'foto_logo',
        'alamat_lengkap', 'domisili', 'nama_produk', 'deskripsi_usaha',
        'nama_pemilik', 'no_hp', 'email', 'website',
        'latitude', 'longitude', 'status', 'is_public',
        'created_by', 'updated_by',
    ];

    protected $hidden = ['no_hp', 'alamat_lengkap'];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_public' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }
    public function scopeActive($q) { return $q->where('status', 'aktif'); }
    public function scopePublicData($q) {
        return $q->select('id_client','nama_ukm','nama_produk','deskripsi_usaha','foto_logo','domisili','status','is_public');
    }
}
