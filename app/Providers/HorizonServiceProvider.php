<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

final class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::routeMailNotificationsTo(email: config(key: 'services.admin-email'));
    }

    protected function gate(): void
    {
        Gate::define(
            ability: 'viewHorizon',
            callback: fn ($user) => $user->email === config(key: 'services.admin-email'));
    }
}
