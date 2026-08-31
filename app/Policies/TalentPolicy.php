<?php

namespace App\Policies;

use App\Models\Talent;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TalentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all, authenticated users can view public data
        return $user->isAdmin() || auth()->check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Talent $talent): bool
    {
        // Admin can view all, talent can view their own profile
        return $user->isAdmin() || $talent->id_user === $user->id_user;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admin can create talent profiles
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Talent $talent): bool
    {
        // Admin can update all, talent can update their own profile
        return $user->isAdmin() || $talent->id_user === $user->id_user;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Talent $talent): bool
    {
        // Only admin can delete talent profiles
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Talent $talent): bool
    {
        // Only admin can restore
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Talent $talent): bool
    {
        // Only admin can force delete
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view sensitive data.
     */
    public function viewSensitiveData(User $user, Talent $talent): bool
    {
        // Admin can view all sensitive data, talent can view their own
        return $user->isAdmin() || $talent->id_user === $user->id_user;
    }
}
