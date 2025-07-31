<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\PriceResource;
use App\Models\Price;

final class PriceController
{
    public function index()
    {
        return new PriceResource(resource: Price::first());
    }
}
