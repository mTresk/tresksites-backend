<?php

namespace App\Models;

use App\Observers\TagWorkObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([TagWorkObserver::class])]
class TagWork extends Pivot
{
    protected $fillable = [
        'work_id',
        'tag_id',
    ];
}
