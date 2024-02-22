<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkResource;
use App\Models\Work;

class WorkController extends Controller
{
    public static function index()
    {
        return WorkResource::collection(Work::latest()->paginate(2));
    }

    public static function featured()
    {
        return WorkResource::collection(Work::where('is_featured', true)->get());
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
}
