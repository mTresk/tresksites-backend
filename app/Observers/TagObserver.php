<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class TagObserver
{
    public function created(Tag $tag): void
    {
        Cache::flush();
    }

    public function updated(Tag $tag): void
    {
        Cache::flush();
    }

    public function deleted(Tag $tag): void
    {
        Cache::flush();
    }

    public function restored(Tag $tag): void
    {
        Cache::flush();
    }

    public function forceDeleted(Tag $tag): void
    {
        Cache::flush();
    }
}
