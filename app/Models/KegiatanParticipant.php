<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanParticipant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kegiatan_participants';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_kegiatan',
        'id_user',
        'status',
        'registered_at',
        'attended_at',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
            'attended_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the kegiatan that this participant is registered for.
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }

    /**
     * Get the user who is the participant.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Scope a query to only include registered participants.
     */
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    /**
     * Scope a query to only include confirmed participants.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include attended participants.
     */
    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    /**
     * Scope a query to only include cancelled participants.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Mark participant as confirmed.
     */
    public function confirm(): bool
    {
        return $this->update(['status' => 'confirmed']);
    }

    /**
     * Mark participant as attended.
     */
    public function markAsAttended(): bool
    {
        return $this->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);
    }

    /**
     * Cancel participant registration.
     */
    public function cancel(): bool
    {
        return $this->update(['status' => 'cancelled']);
    }
}