<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PriceResource;
use App\Models\Price;

final class PriceController
{
    public function index()
    {
        return PriceResource::make(Price::first());
    }
}
