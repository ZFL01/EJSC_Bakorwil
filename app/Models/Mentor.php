<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

        /**
     * Ubah nilai file/URL dari database menjadi URL absolut yang aman.
     * Database berisi campuran: URL absolut (http/data:), path storage,
     * atau nama file mentah ("PORTOFOLIO RIZAL .pdf", dll).
     *
     * - URL absolut (termasuk Google Drive): cek dulu apakah file
     *   tersedia di storage lokal berdasarkan Drive File ID. Jika ada,
     *   pakai URL lokal (hindar 404 karena file Drive yang sudah tidak
     *   publik). Jika tidak ada, kembalikan URL aslinya.
     * - Nilai storage dengan nama file berupa Google Drive File ID
     *   (mis. storage/mentor/cv/lutfi/19YZzU6uFpIUg16gOL9lQMJdDG-ohaTlB.pdf)
     *   diubah kembali menjadi link Google Drive, karena file fisik
     *   tersebut tidak disimpan di server.
     * - Path lain dibungkus url() agar tidak dianggap URL relatif.
     */
    protected function safeFileUrl(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        // URL absolut — khususnya Google Drive, cek apakah file sudah ada
        // di storage lokal berdasarkan Drive File ID di namanya.
        if (preg_match('#^(https?:|data:|//)#i', $value) === 1) {
            if (preg_match('#drive\.google\.com#i', $value) === 1) {
                $localUrl = $this->resolveDriveToLocal($value);
                if ($localUrl !== null) {
                    return $localUrl;
                }
            }
            return $value;
        }

        // Pola: storage/<modul>/<sub>/<slug>/<file>.<ext>
        if (preg_match('#^storage/#', $value) === 1) {
            $relative = preg_replace('#^storage/#', '', $value);

            // Kalau file-nya benar-benar ada di storage lokal, pakai file asli.
            if (Storage::disk('public')->exists($relative)) {
                return asset($value);
            }

            // Kalau nama file berupa Google Drive File ID, buka via Google Drive.
            if (preg_match('#/([0-9A-Za-z_-]{20,})\.[A-Za-z0-9]{1,10}$#', $value, $m) === 1) {
                return 'https://drive.google.com/file/d/' . $m[1] . '/view';
            }

            // Path storage tapi file tidak ada dan bukan Drive ID → tanpa link.
            return null;
        }

        // Nilai lain (mis. "PORTOFOLIO RIZAL .pdf") tanpa file nyata → tanpa link,
        // agar tidak menghasilkan URL relatif yang berujung 404.
        return null;
    }

    /**
     * Dari URL Google Drive, ekstrak File ID lalu cari file fisik di
     * storage/app/public berdasarkan ID tersebut.
     *
     * File-file hasil download Drive diberi nama = Google Drive File ID,
     * mis. 19YZzU6uFpIUg16gOL9lQMJdDG-ohaTlB.pdf
     *
     * Jika ditemukan, kembalikan asset('storage/...') agar browser bisa
     * mengakses langsung dari server lokal — ini mencegah 404 yang disebabkan
     * Google Drive yang sudah tidak publik/di-share.
     *
     * @return string|null  URL lokal jika ditemukan, null jika tidak.
     */
    protected function resolveDriveToLocal(string $driveUrl): ?string
    {
        // Dukung format URL Google Drive yang umum
        $driveId = null;

        if (preg_match('#/file/d/([0-9A-Za-z_-]{20,})#i', $driveUrl, $m)) {
            $driveId = $m[1];
        } elseif (preg_match('#[?&]id=([0-9A-Za-z_-]{20,})#i', $driveUrl, $m)) {
            $driveId = $m[1];
        }

        if ($driveId === null) {
            return null;
        }

        // Cache statis: hindari pencarian filesystem yang sama berulang kali
        // dalam satu request (mis. daftar 15 mentor di halaman yang sama).
        static $cache = [];
        if (array_key_exists($driveId, $cache)) {
            return $cache[$driveId];
        }

        // Cari file di storage lokal dengan nama yang dimulai dari Drive ID.
        // Struktur: storage/app/public/<entity>/<kind>/<slug>/<drive_id>.<ext>
        $root = str_replace('\\', '/', storage_path('app/public'));

        // Level 3: <entity>/<kind>/<slug>/<drive_id>.<ext>
        $matches = glob($root . '/*/*/*/' . $driveId . '.*');

        if (empty($matches)) {
            // Level 2: <entity>/<drive_id>.<ext>
            $matches = glob($root . '/*/' . $driveId . '.*');
        }

        if (!empty($matches)) {
            $found = str_replace('\\', '/', $matches[0]);
            $relative = substr($found, strlen($root) + 1);

            return $cache[$driveId] = asset('storage/' . $relative);
        }

        // File tidak ada di lokal → fallback ke URL Drive asli
        return $cache[$driveId] = null;
    }

    /** URL portofolio yang sudah dinormalkan untuk href aman. */
    public function getPortofolioSrcAttribute(): ?string
    {
        return $this->safeFileUrl($this->portofolio_url);
    }

    /** URL CV yang sudah dinormalkan untuk href aman. */
    public function getCvSrcAttribute(): ?string
    {
        return $this->safeFileUrl($this->url_cv);
    }

    /** URL KTP yang sudah dinormalkan untuk href aman. */
    public function getKtpSrcAttribute(): ?string
    {
        return $this->safeFileUrl($this->url_ktp);
    }

    /** URL Bukti Tabungan yang sudah dinormalkan untuk href aman. */
    public function getButapSrcAttribute(): ?string
    {
        return $this->safeFileUrl($this->url_butap);
    }
}
