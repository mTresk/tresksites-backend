<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Http\Resources\WorkResource;
use App\Models\Work;
use Illuminate\Support\Facades\Cache;

class WorkController extends Controller
{
    public static function index()
    {
        $page = request()->input('page') ?? 1;

        return WorkResource::collection(Cache::rememberForever('works' . $page, function () {
            return Work::latest()->paginate(5);
        }));
    }

    public static function featured()
    {
        return WorkResource::collection(Cache::rememberForever('featured', function () {
            return Work::where('is_featured', true)->get();
        }));
    }

    public static function show(Work $work)
    {
        $data = WorkResource::make($work);

        $otherWorks = WorkResource::collection(Work::select()
            ->where('id', '!=', $work->id)
            ->inRandomOrder()
            ->limit(3)
            ->get());

        return compact('data', 'otherWorks');
    }

    public static function routes()
    {
        return RouteResource::collection(Work::all());
    }
}
