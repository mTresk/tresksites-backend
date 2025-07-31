<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

final class WorkObserver
{
    public function created(): void
    {
        Cache::flush();
    }

    public function updated(): void
    {
        Cache::flush();
    }

    public function deleted(): void
    {
        Cache::flush();
    }

    public function restored(): void
    {
        Cache::flush();
    }

    public function forceDeleted(): void
    {
        Cache::flush();
    }
}
