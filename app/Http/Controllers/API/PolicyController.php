<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PolicyResource;
use App\Models\Policy;

class PolicyController extends Controller
{
    public function index()
    {
        return PolicyResource::make(Policy::first());
    }
}
