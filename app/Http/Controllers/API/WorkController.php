<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\RouteResource;
use App\Http\Resources\WorkCollectionResource;
use App\Http\Resources\WorkResource;
use App\Models\Work;
use Illuminate\Support\Facades\Cache;

final class WorkController
{
    public static function index()
    {
        $page = request()->input(key: 'page') ?? 1;

        $works = Work::query()
            ->latest()
            ->paginate(perPage: 5);

        $resource = Cache::rememberForever(
            key: 'works'.$page,
            callback: fn () => $works
        );

        return WorkCollectionResource::collection(resource: $resource);
    }

    public static function featured()
    {
        $works = Work::query()
            ->where(
                column: 'is_featured',
                operator: '=',
                value: true)
            ->orderBy('order_column')
            ->get();

        $resource = Cache::rememberForever(
            key: 'featured',
            callback: fn () => $works
        );

        return WorkCollectionResource::collection(resource: $resource);
    }

    public static function show(Work $work)
    {
        $works = Work::query()
            ->where(
                column: 'id',
                operator: '!=',
                value: $work->id
            )
            ->inRandomOrder()
            ->take(value: 3)
            ->get();

        return [
            'data' => new WorkResource(resource: $work),
            'otherWorks' => WorkCollectionResource::collection(resource: $works),
        ];
    }

    public static function routes()
    {
        return RouteResource::collection(resource: Work::get());
    }
}
