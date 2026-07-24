<?php

namespace App\Policies;

use App\Models\Play;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlayPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        // Spatie ile admin kontrolü
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view plays');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Play $play): bool
    {
        return $user->hasPermissionTo('view plays');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create plays');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Play $play): bool
    {
        return $user->hasPermissionTo('edit plays');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Play $play): bool
    {
        return $user->hasPermissionTo('delete plays');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Play $play): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Play $play): bool
    {
        return false;
    }
}
