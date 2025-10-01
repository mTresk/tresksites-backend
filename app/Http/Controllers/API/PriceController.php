<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Actions\Price\GetPrice;
use App\Http\Resources\PriceResource;

final class PriceController
{
    public function index(GetPrice $getPrice): PriceResource
    {
        return new PriceResource(resource: $getPrice->handle());
    }
}
