<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\WorkCollectionResource;
use App\Models\Work;

final class TagController
{
    public static function index(string $slug)
    {
        return WorkCollectionResource::collection(
            Work::query()
                ->whereRelation('tags', 'slug', $slug)
                ->latest()
                ->paginate(5)
        );
    }
}
