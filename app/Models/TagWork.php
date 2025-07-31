<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\TagWorkObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([TagWorkObserver::class])]
final class TagWork extends Pivot
{
    public $incrementing = true;
}
