<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\SearchResource;
use App\Models\Work;

final class SearchController
{
    public function search(SearchRequest $request)
    {
        $works = Work::search(query: $request->input(key: 'keywords'))->get();

        return SearchResource::collection(resource: $works);
    }
}
