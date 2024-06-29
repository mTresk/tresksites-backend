<?php

namespace App\Http\Resources;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Work */
class RouteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'updated_at' => $this->updated_at
        ];
    }
}
