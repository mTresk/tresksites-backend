<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ServiceResource;
use App\Models\Service;

final class ServiceController
{
    public function index()
    {
        return ServiceResource::collection(Service::all());
    }
}
