<?php

namespace App\Http\Resources;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Price */
class PriceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'block' => $this->block,
        ];
    }
}
