<?php

namespace App\Policies;

use App\Models\TicketSale;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view tickets');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketSale $ticketSale): bool
    {
        return $user->hasPermissionTo('view tickets');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TicketSale $ticketSale): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketSale $ticketSale): bool
    {
        return $user->hasPermissionTo('delete tickets');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TicketSale $ticketSale): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TicketSale $ticketSale): bool
    {
        return false;
    }
}
