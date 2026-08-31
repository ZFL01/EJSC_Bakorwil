<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_ejsc';
    protected $primaryKey = 'id_kegiatan';
    public $timestamps = true;

    protected $fillable = [
        'judul_kegiatan', 'deskripsi', 'gambar', 'tanggal_kegiatan',
        'status', 'organizer_id', 'lokasi', 'max_participants',
        'is_public', 'gallery',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
            'is_public' => 'boolean',
            'gallery' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function organizer() { return $this->belongsTo(User::class, 'organizer_id'); }
    public function participants() { return $this->belongsToMany(User::class, 'kegiatan_participants', 'id_kegiatan', 'id_user')
                    ->withPivot('status', 'registered_at', 'attended_at', 'notes')
                    ->withTimestamps(); }
    public function participantRecords() { return $this->hasMany(KegiatanParticipant::class, 'id_kegiatan'); }
    public function scopeUpcoming($q) { return $q->where('tanggal_kegiatan', '>=', now())->where('status', 'akan_datang'); }
    public function scopePublic($q) { return $q->where('is_public', true); }

    public function hasAvailableSlots(): bool
    {
        if (is_null($this->max_participants)) {
            return true;
        }

        $registeredCount = $this->participantRecords()
            ->where('status', '!=', 'cancelled')
            ->count();

        return $registeredCount < $this->max_participants;
    }
}
