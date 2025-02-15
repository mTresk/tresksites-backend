<?php

namespace App\Models;

use App\Observers\WorkObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Laravel\Scout\Searchable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([WorkObserver::class])]
class Work extends Model implements HasMedia
{
    use InteractsWithMedia;

    use Searchable;

    protected $fillable = [
        'name',
        'slug',
        'label',
        'url',
        'list',
        'content',
        'is_featured',
    ];

    protected $casts = [
        'content' => 'array',
        'is_featured' => 'boolean',
    ];

    public function seo(): MorphOne
    {
        return $this->morphOne(SEO::class, 'model')->withDefault();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('featuredSm')
            ->performOnCollections('featured')
            ->fit(Fit::Contain, 400)
            ->nonQueued();

        $this->addMediaConversion('featured')
            ->performOnCollections('featured')
            ->fit(Fit::Contain, 1058)
            ->nonQueued();

        $this->addMediaConversion('featuredWebpSm')
            ->performOnCollections('featured')
            ->format('webp')
            ->fit(Fit::Contain, 400)
            ->nonQueued();

        $this->addMediaConversion('featuredWebp')
            ->performOnCollections('featured')
            ->format('webp')
            ->fit(Fit::Contain, 1058)
            ->nonQueued();

        $this->addMediaConversion('featuredSm@2')
            ->performOnCollections('featured')
            ->fit(Fit::Contain, 800)
            ->nonQueued();

        $this->addMediaConversion('featured@2')
            ->performOnCollections('featured')
            ->fit(Fit::Contain, 2116)
            ->nonQueued();

        $this->addMediaConversion('featuredWebpSm@2')
            ->performOnCollections('featured')
            ->format('webp')
            ->fit(Fit::Contain, 800)
            ->nonQueued();

        $this->addMediaConversion('featuredWebp@2')
            ->performOnCollections('featured')
            ->format('webp')
            ->fit(Fit::Contain, 2116)
            ->nonQueued();

        $this->addMediaConversion('workSm')
            ->performOnCollections('works')
            ->fit(Fit::Contain, 400)
            ->nonQueued();

        $this->addMediaConversion('work')
            ->performOnCollections('works')
            ->fit(Fit::Contain, 1000)
            ->nonQueued();

        $this->addMediaConversion('workWebpSm')
            ->performOnCollections('works')
            ->format('webp')
            ->fit(Fit::Contain, 400)
            ->nonQueued();

        $this->addMediaConversion('workWebp')
            ->performOnCollections('works')
            ->format('webp')
            ->fit(Fit::Contain, 1000)
            ->nonQueued();

        $this->addMediaConversion('workSm@2')
            ->performOnCollections('works')
            ->fit(Fit::Contain, 800)
            ->nonQueued();

        $this->addMediaConversion('work@2')
            ->performOnCollections('works')
            ->fit(Fit::Contain, 2000)
            ->nonQueued();

        $this->addMediaConversion('workWebpSm@2')
            ->performOnCollections('works')
            ->format('webp')
            ->fit(Fit::Contain, 800)
            ->nonQueued();

        $this->addMediaConversion('workWebp@2')
            ->performOnCollections('works')
            ->format('webp')
            ->fit(Fit::Contain, 2000)
            ->nonQueued();
    }


    protected function setContent(): Attribute
    {
        $media = $this->getMedia('works');

        $galleryMap = collect($media)->mapWithKeys(function ($image) {
            return [
                $image->custom_properties['gallery_id'] => [
                    'imageSm' => $image->getUrl('workSm'),
                    'image' => $image->getUrl('work'),
                    'imageWebpSm' => $image->getUrl('workWebpSm'),
                    'imageWebp' => $image->getUrl('workWebp'),
                    'imageSmX2' => $image->getUrl('workSm@2'),
                    'imageX2' => $image->getUrl('work@2'),
                    'imageWebpSmX2' => $image->getUrl('workWebpSm@2'),
                    'imageWebpX2' => $image->getUrl('workWebp@2')
                ]
            ];
        });

        $content = collect($this->content)->map(function ($item) use ($galleryMap) {
            if (!empty($item['data']['gallery_id']) && isset($galleryMap[$item['data']['gallery_id']])) {
                $item['data']['images'] = $galleryMap[$item['data']['gallery_id']];
            }
            return $item;
        })->toArray();

        return Attribute::make(
            get: fn() => $content,
        );
    }


    protected function featured(): Attribute
    {
        $images = collect($this->getMedia('featured'))->map(fn($image
        ) => $this->formatFeaturedImage($image))->first();

        return Attribute::make(
            get: fn() => $images,
        );
    }

    private function formatFeaturedImage($image): array
    {
        return [
            'imageSm' => $image->getUrl('featuredSm'),
            'featured' => $image->getUrl('featured'),
            'imageWebpSm' => $image->getUrl('featuredWebpSm'),
            'imageWebp' => $image->getUrl('featuredWebp'),
            'imageSmX2' => $image->getUrl('featuredSm@2'),
            'imageX2' => $image->getUrl('featured@2'),
            'imageWebpSmX2' => $image->getUrl('featuredWebpSm@2'),
            'imageWebpX2' => $image->getUrl('featuredWebp@2'),
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'content' => $this->content,
            'list' => $this->list
        ];
    }
}
