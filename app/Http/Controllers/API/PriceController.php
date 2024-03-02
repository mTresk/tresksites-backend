<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriceResource;
use App\Models\Price;

class PriceController extends Controller
{
    public function index()
    {
        return PriceResource::make(Price::first());
    }
}
