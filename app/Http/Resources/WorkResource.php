<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->name,
            'slug' => $this->slug,
            'label' => $this->label,
            'url' => $this->url,
            'list' => $this->list,
            'content' => $this->setContent,
            'featured' => [
                'image' => $this->featured->featured,
                'imageSm' => $this->featured->featuredSm,
                'imageWebpSm' => $this->featured->featuredWebpSm,
                'imageWebp' => $this->featured->featuredWebp,
                'imageSmX2' => $this->featured->featuredSmX2,
                'imageX2' => $this->featured->featuredX2,
                'imageWebpSmX2' => $this->featured->featuredWebpSmX2,
                'imageWebpX2' => $this->featured->featuredWebpX2,
            ],
            'seo' => SeoResource::make($this->seo)
        ];
    }
}
