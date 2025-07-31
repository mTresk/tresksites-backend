<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Work
 *
 * @property mixed $setContent
 */
final class WorkCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->name,
            'slug' => $this->slug,
            'label' => $this->label,
            'tags' => TagResource::collection(resource: $this->tags),
            'url' => $this->url,
            'list' => $this->list,
            'featured' => $this->featured,
        ];
    }
}
