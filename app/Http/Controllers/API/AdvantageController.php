<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvantageResource;
use App\Models\Advantage;

class AdvantageController extends Controller
{
    public function index()
    {
        return AdvantageResource::make(Advantage::first());
    }
}
