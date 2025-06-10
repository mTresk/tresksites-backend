<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\SearchResource;
use App\Models\Work;

final class SearchController
{
    public function search(SearchRequest $request)
    {
        return SearchResource::collection(Work::search($request->input('keywords'))->get());
    }
}
