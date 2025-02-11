<?php

namespace App\Http\Resources;

use App\Models\Advantage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Advantage */
class AdvantageResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'block' => $this->block,
        ];
    }
}
