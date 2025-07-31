<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

final class TagWorkObserver
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
}
