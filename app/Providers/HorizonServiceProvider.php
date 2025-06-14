<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::routeMailNotificationsTo(config('services.admin-email'));
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return $user->email == config('services.admin-email');
        });
    }
}
