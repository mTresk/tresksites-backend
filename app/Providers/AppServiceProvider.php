<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        ResourceCollection::withoutWrapping();

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Order::observe(OrderObserver::class);
    }
}
