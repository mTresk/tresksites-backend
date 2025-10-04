<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Actions\Service\GetServices;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ServiceController
{
    public function index(GetServices $getServices): AnonymousResourceCollection
    {
        return ServiceResource::collection(resource: $getServices->handle());
    }
}
