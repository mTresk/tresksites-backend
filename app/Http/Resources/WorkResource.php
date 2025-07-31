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
final class WorkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->name,
            'slug' => $this->slug,
            'tags' => TagResource::collection(resource: $this->tags),
            'label' => $this->label,
            'url' => $this->url,
            'list' => $this->list,
            'content' => $this->setContent,
            'featured' => $this->featured,
            'seo' => new SeoResource(resource: $this->seo),
        ];
    }
}
