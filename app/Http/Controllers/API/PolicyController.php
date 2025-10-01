<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Actions\Policy\GetPolicy;
use App\Http\Resources\PolicyResource;

final class PolicyController
{
    public function index(GetPolicy $getPolicy): PolicyResource
    {
        return new PolicyResource(resource: $getPolicy->handle());
    }
}
