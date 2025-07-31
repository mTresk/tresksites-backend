<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\WorkCollectionResource;
use App\Models\Work;

final class TagController
{
    public static function index(string $slug)
    {
        $works = Work::query()
            ->whereRelation(
                relation: 'tags',
                column: 'slug',
                operator: '=',
                value: $slug
            )
            ->latest()
            ->paginate(perPage: 5);

        return WorkCollectionResource::collection(resource: $works);
    }
}
