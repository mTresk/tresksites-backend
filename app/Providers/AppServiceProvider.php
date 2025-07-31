<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        ResourceCollection::withoutWrapping();

        if (config(key: 'app.env') === 'production') {
            URL::forceScheme(scheme: 'https');
        }
    }
}
