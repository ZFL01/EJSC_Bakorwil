<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $table = 'mentor';
    protected $primaryKey = 'id_mentor';
    public $timestamps = true;

    protected $fillable = [
        'id_user', 'id_wilayah', 'nama', 'jenis_kelamin', 'foto',
        'domisili', 'alamat_lengkap', 'no_wa', 'email', 'bio',
        'keahlian', 'pengalaman', 'portofolio_url', 'latitude', 'longitude',
        'status', 'is_public', 'url_cv', 'url_ktp', 'url_butap',
        'created_by', 'updated_by', 'expertise_tags', 'is_available', 'jumlah_mentee',
    ];

    protected $hidden = ['no_wa', 'alamat_lengkap'];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_public' => 'boolean',
            'is_available' => 'boolean',
            'expertise_tags' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }
    public function talents() { return $this->hasMany(Talent::class, 'mentor_id'); }
    public function scopeActive($q) { return $q->where('status', 'aktif'); }
    public function scopePublicData($q) {
        return $q->select(
            'id_mentor','id_user','id_wilayah','nama','jenis_kelamin','foto',
            'domisili','alamat_lengkap','no_wa','email','bio','keahlian',
            'pengalaman','portofolio_url','status','is_public','url_cv',
            'expertise_tags','is_available','jumlah_mentee'
        );
    }

    /**
     * Tentukan kategori bidang dari data mentor.
     * Dipakai oleh halaman publik (filter & badge) dan controller.
     */
    public static function bidangKey($mentor): string
    {
        $bidang = strtolower((string) ($mentor->bidang ?? ''));

        if ($bidang !== '') {
            return $bidang;
        }

        $keahlian = strtolower((string) ($mentor->keahlian ?? ''));

        if (
            str_contains($keahlian, 'program')
            || str_contains($keahlian, 'software')
            || str_contains($keahlian, 'teknologi')
            || str_contains($keahlian, 'cloud')
            || str_contains($keahlian, 'data')
            || preg_match('/\b(ai)\b/', $keahlian)
        ) {
            return 'teknologi';
        }

        if (
            str_contains($keahlian, 'bisnis')
            || str_contains($keahlian, 'marketing')
            || str_contains($keahlian, 'usaha')
        ) {
            return 'bisnis';
        }

        if (
            str_contains($keahlian, 'desain')
            || str_contains($keahlian, 'design')
            || preg_match('/\b(ui|ux)\b/', $keahlian)
        ) {
            return 'desain';
        }

        return 'pendidikan';
    }
}
