<?php

namespace App\Observers;

use App\Models\Work;
use Illuminate\Support\Facades\Cache;

class WorkObserver
{
    public function created(Work $work): void
    {
        Cache::flush();
    }

    public function updated(Work $work): void
    {
        Cache::flush();
    }

    public function deleted(Work $work): void
    {
        Cache::flush();
    }

    public function restored(Work $work): void
    {
        Cache::flush();
    }
    
    public function forceDeleted(Work $work): void
    {
        Cache::flush();
    }
}
