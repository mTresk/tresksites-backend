<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Actions\Advantage\GetAdvantages;
use App\Http\Resources\AdvantageResource;

final class AdvantageController
{
    public function index(GetAdvantages $getAdvantages): AdvantageResource
    {
        return new AdvantageResource(resource: $getAdvantages->handle());
    }
}
