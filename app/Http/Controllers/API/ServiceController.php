<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\ServiceResource;
use App\Models\Service;

final class ServiceController
{
    public function index()
    {
        return ServiceResource::collection(resource: Service::get());
    }
}
