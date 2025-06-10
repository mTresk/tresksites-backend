<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PolicyResource;
use App\Models\Policy;

final class PolicyController
{
    public function index()
    {
        return PolicyResource::make(Policy::first());
    }
}
