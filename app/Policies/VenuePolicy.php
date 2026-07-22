<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\Response;
class VenuePolicy
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
        return $user->hasPermissionTo('view venues');
    }

    public function view(User $user, Venue $venue): bool
    {
        return $user->hasPermissionTo('view venues');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create venues');
    }

    public function update(User $user, Venue $venue): bool
    {
        return $user->hasPermissionTo('edit venues');
    }

    public function delete(User $user, Venue $venue): bool
    {
        return $user->hasPermissionTo('delete venues');
    }
}