<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\PolicyResource;
use App\Models\Policy;

final class PolicyController
{
    public function index()
    {
        return new PolicyResource(resource: Policy::first());
    }
}
