<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class TagObserver
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
