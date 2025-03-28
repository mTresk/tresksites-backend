<?php

namespace App\Models;

use App\Observers\TagObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([TagObserver::class])]
class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class)->using(TagWork::class);
    }
}
