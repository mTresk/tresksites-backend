<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Actions\Work\GetAllWorks;
use App\Http\Actions\Work\GetFeaturedWorks;
use App\Http\Actions\Work\GetOtherWorks;
use App\Http\Actions\Work\GetWorks;
use App\Http\Actions\Work\GetWorksByTag;
use App\Http\Resources\RouteResource;
use App\Http\Resources\WorkCollectionResource;
use App\Http\Resources\WorkResource;
use App\Models\Work;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

final class WorkController
{
    public static function index(GetWorks $getWorks): AnonymousResourceCollection
    {
        $page = request()->input(key: 'page') ?? 1;

        $works = Cache::rememberForever(
            key: 'works'.$page,
            callback: fn () => $getWorks->handle(perPage: 5)
        );

        return WorkCollectionResource::collection(resource: $works);
    }

    public static function featured(GetFeaturedWorks $getFeaturedWorks): AnonymousResourceCollection
    {
        $works = Cache::rememberForever(
            key: 'featured',
            callback: fn () => $getFeaturedWorks->handle()
        );

        return WorkCollectionResource::collection(resource: $works);
    }

    public static function show(Work $work, GetOtherWorks $getOtherWorks): array
    {
        $otherWorks = $getOtherWorks->handle(workId: $work->id);

        return [
            'data' => new WorkResource(resource: $work),
            'otherWorks' => WorkCollectionResource::collection(resource: $otherWorks),
        ];
    }

    public static function routes(GetAllWorks $getAllWorks): AnonymousResourceCollection
    {
        return RouteResource::collection(resource: $getAllWorks->handle());
    }

    public function tags(string $slug, GetWorksByTag $getWorksByTag): AnonymousResourceCollection
    {
        $works = $getWorksByTag->handle(
            slug: $slug,
            perPage: 5
        );

        return WorkCollectionResource::collection(resource: $works);
    }
}
