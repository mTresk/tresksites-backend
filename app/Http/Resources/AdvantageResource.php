<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Advantage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Advantage
 */
final class AdvantageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            ...$this->block,
        ];
    }
}
