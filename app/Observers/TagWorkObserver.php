<?php

namespace App\Observers;

use App\Models\TagWork;
use Illuminate\Support\Facades\Cache;

class TagWorkObserver
{
    public function created(TagWork $tagWork): void
    {
        Cache::flush();
    }

    public function updated(TagWork $tagWork): void
    {
        Cache::flush();
    }

    public function deleted(TagWork $tagWork): void
    {
        Cache::flush();
    }

    public function restored(TagWork $tagWork): void
    {
        Cache::flush();
    }

    public function forceDeleted(TagWork $tagWork): void
    {
        Cache::flush();
    }
}
