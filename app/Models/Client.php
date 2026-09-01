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
        return $q->select(
            'id_client','id_user','id_wilayah','nama_ukm','foto_logo',
            'alamat_lengkap','domisili','nama_produk','deskripsi_usaha',
            'nama_pemilik','no_hp','email','website','status','is_public'
        );
    }

    /**
     * Tentukan kategori usaha client (umkm/korporasi/startup/pemerintahan).
     * Dipakai oleh halaman publik (filter & badge) dan controller.
     */
    public static function kategoriKey($client): string
    {
        $text = strtolower(trim(implode(' ', array_filter([
            $client->kategori ?? '',
            $client->jenis_usaha ?? '',
            $client->nama_ukm ?? '',
            $client->nama_produk ?? '',
            $client->deskripsi_usaha ?? '',
            $client->website ?? '',
        ]))));

        if (
            str_contains($text, 'korporasi')
            || str_contains($text, 'perseroan')
            || preg_match('/\b(pt|tbk|cv|perusahaan)\b/', $text)
        ) {
            return 'korporasi';
        }

        if (
            str_contains($text, 'startup')
            || str_contains($text, 'technopreneur')
        ) {
            return 'startup';
        }

        if (
            str_contains($text, 'pemerintah')
            || str_contains($text, 'pemda')
            || str_contains($text, 'dinas')
            || str_contains($text, 'bumdes')
            || str_contains($text, 'instansi')
        ) {
            return 'pemerintahan';
        }

        return 'umkm';
    }

    /**
     * URL website yang aman: tambahkan skema https:// bila belum ada,
     * agar nilai seperti "www.example.com" tidak dianggap URL relatif.
     */
    public function getWebsiteSrcAttribute(): ?string
    {
        $website = trim((string) $this->website);

        if ($website === '') {
            return null;
        }

        if (preg_match('#^(https?:|//)#i', $website) === 1) {
            return $website;
        }

        return 'https://' . $website;
    }
}
