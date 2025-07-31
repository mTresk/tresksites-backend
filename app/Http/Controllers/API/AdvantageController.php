<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\AdvantageResource;
use App\Models\Advantage;

final class AdvantageController
{
    public function index()
    {
        return new AdvantageResource(resource: Advantage::first());
    }
}
