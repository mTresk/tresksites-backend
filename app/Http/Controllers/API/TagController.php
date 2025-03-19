<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkCollectionResource;
use App\Models\Work;

class TagController extends Controller
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
