<?php

namespace App\Providers;

use App\Models\TicketSale;
use App\Policies\TicketPolicy;
use Illuminate\Support\ServiceProvider;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Gate::policy(User::class, UserPolicy::class);
        Gate::policy(TicketSale::class, TicketPolicy::class);

    }
}
