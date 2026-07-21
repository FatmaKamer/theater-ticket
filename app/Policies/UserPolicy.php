<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function before(User $user, string $ability): ?bool //bu fonksiyon sayesinde admin için tüm fonk tek tek kontrol edilmez.
    {
        if ($ability === 'delete') {
            return null; // delete için before'u atla, kendi metoduna git
        }
        // Kullanıcı admin ise her şeyi yapabilir
        if ($user->isAdmin()) {
            return true;
        }
        
        // Admin değilse, diğer metodlar devreye girsin
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $target): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $target): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $target): bool
    {
        if ($user->id === $target->id) {
            return false;
        }
        
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $target): bool
    {
        if ($user->id === $target->id) {
            return false;
        }
        
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $target): bool
    {
        return $user->isAdmin();
    }
}
