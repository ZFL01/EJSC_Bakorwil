<?php

namespace App\Policies;

use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KegiatanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Everyone can view public kegiatan, authenticated users can view all
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Kegiatan $kegiatan): bool
    {
        // Public can view public kegiatan, authenticated users can view all
        if ($kegiatan->is_public) {
            return true;
        }
        
        return $user !== null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admin can create kegiatan
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kegiatan $kegiatan): bool
    {
        // Admin can update all, organizer can update their own kegiatan
        return $user->isAdmin() || $kegiatan->organizer_id === $user->id_user;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kegiatan $kegiatan): bool
    {
        // Only admin can delete kegiatan
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kegiatan $kegiatan): bool
    {
        // Only admin can restore
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kegiatan $kegiatan): bool
    {
        // Only admin can force delete
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can register for the kegiatan.
     */
    public function register(User $user, Kegiatan $kegiatan): bool
    {
        // Authenticated users can register for kegiatan
        return auth()->check() && $kegiatan->hasAvailableSlots();
    }

    /**
     * Determine whether the user can manage participants.
     */
    public function manageParticipants(User $user, Kegiatan $kegiatan): bool
    {
        // Admin and organizer can manage participants
        return $user->isAdmin() || $kegiatan->organizer_id === $user->id_user;
    }
}
