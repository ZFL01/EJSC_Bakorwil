<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talenta';
    protected $primaryKey = 'id_talenta';
    public $timestamps = true;

    protected $fillable = [
        'id_user', 'id_wilayah', 'nama', 'jenis_kelamin', 'foto',
        'domisili', 'alamat_lengkap', 'no_wa', 'email', 'bidang_pekerjaan',
        'keahlian', 'bio', 'pengalaman', 'portofolio_url', 'latitude', 'longitude',
        'status', 'is_public', 'url_cv', 'url_ktp', 'url_butap',
        'created_by', 'updated_by', 'skill_tags', 'mentor_id', 'status_pekerjaan',
    ];

    protected $hidden = ['no_wa', 'alamat_lengkap'];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_public' => 'boolean',
            'skill_tags' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function mentor() { return $this->belongsTo(Mentor::class, 'mentor_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }
    public function scopeActive($q) { return $q->where('status', 'aktif'); }
    public function scopePublicData($q) {
        return $q->select(
            'id_talenta','id_user','id_wilayah','nama','jenis_kelamin','foto',
            'domisili','alamat_lengkap','no_wa','email','bidang_pekerjaan',
            'keahlian','bio','pengalaman','portofolio_url','status','is_public',
            'url_cv','skill_tags','mentor_id','status_pekerjaan'
        );
    }

    /**
     * Tentukan kategori skill dari data talenta.
     * Dipakai oleh halaman publik (filter & badge) dan controller.
     */
    public static function skillKey($talent): string
    {
        $keahlian = strtolower((string) ($talent->keahlian ?? ''));

        if (
            str_contains($keahlian, 'program')
            || str_contains($keahlian, 'developer')
            || str_contains($keahlian, 'software')
        ) {
            return 'programming';
        }

        if (
            str_contains($keahlian, 'design')
            || str_contains($keahlian, 'desain')
            || preg_match('/\b(ui|ux)\b/', $keahlian)
        ) {
            return 'design';
        }

        if (str_contains($keahlian, 'marketing')) {
            return 'marketing';
        }

        return 'data';
    }
}
