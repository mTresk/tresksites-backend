<?php

namespace App\Http\Resources;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Work
 * @property mixed $setContent
 */
class WorkResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->name,
            'slug' => $this->slug,
            'tags' => TagResource::collection($this->tags),
            'label' => $this->label,
            'url' => $this->url,
            'list' => $this->list,
            'content' => $this->setContent,
            'featured' => $this->featured,
            'seo' => SeoResource::make($this->seo)
        ];
    }
}
