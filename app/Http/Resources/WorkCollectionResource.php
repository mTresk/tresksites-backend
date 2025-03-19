<?php

namespace App\Http\Resources;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Work
 * @property mixed $setContent
 */
class WorkCollectionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->name,
            'slug' => $this->slug,
            'label' => $this->label,
            'tags' => TagResource::collection($this->tags),
            'url' => $this->url,
            'list' => $this->list,
            'featured' => $this->featured,
        ];
    }
}
