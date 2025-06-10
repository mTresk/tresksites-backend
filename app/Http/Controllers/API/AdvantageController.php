<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AdvantageResource;
use App\Models\Advantage;

final class AdvantageController
{
    public function index()
    {
        return AdvantageResource::make(Advantage::first());
    }
}
