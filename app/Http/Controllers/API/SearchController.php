<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Work;

class SearchController extends Controller
{
    public function search(SearchRequest $request)
    {
        return Work::search($request->input('keywords'))->get();
    }
}
