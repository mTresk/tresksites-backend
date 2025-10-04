<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Actions\Search\HandleSearch;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\SearchResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SearchController
{
    public function search(SearchRequest $request, HandleSearch $handleSearch): AnonymousResourceCollection
    {
        $query = $request->validated(key: 'keywords');

        $works = $handleSearch->handle(query: $query);

        return SearchResource::collection(resource: $works);
    }
}
