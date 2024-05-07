<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Work extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'label', 'url', 'list', 'content', 'is_featured'];

    protected $casts = ['content' => 'array', 'is_featured' => 'boolean'];

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
        $content = [];

        foreach ($this->content as $item) {
            if (isset($item['data']['gallery_id'])) {
                foreach ($media as $image) {
                    if ($item['data']['gallery_id'] == $image->custom_properties['gallery_id']) {
                        $item['data']['images'] = [
                            'imageSm' => $image->getUrl('workSm'),
                            'image' => $image->getUrl('work'),
                            'imageWebpSm' => $image->getUrl('workWebpSm'),
                            'imageWebp' => $image->getUrl('workWebp'),
                            'imageSmX2' => $image->getUrl('workSm@2'),
                            'imageX2' => $image->getUrl('work@2'),
                            'imageWebpSmX2' => $image->getUrl('workWebpSm@2'),
                            'imageWebpX2' => $image->getUrl('workWebp@2')];

                        $content[] = $item;
                    }
                }
            } else {
                $content[] = $item;
            }
        }

        return Attribute::make(
            get: fn() => $content,
        );
    }

    protected function featured(): Attribute
    {
        $data = $this->getMedia('featured');
        $images = [];

        foreach ($data as $image) {
            $image->featuredSm = $image->getUrl('featuredSm');
            $image->featured = $image->getUrl('featured');
            $image->featuredWebpSm = $image->getUrl('featuredWebpSm');
            $image->featuredWebp = $image->getUrl('featuredWebp');
            $image->featuredSmX2 = $image->getUrl('featuredSm@2');
            $image->featuredX2 = $image->getUrl('featured@2');
            $image->featuredWebpSmX2 = $image->getUrl('featuredWebpSm@2');
            $image->featuredWebpX2 = $image->getUrl('featuredWebp@2');
            $images = $image;
        }

        return Attribute::make(
            get: fn() => $images,
        );
    }
}
