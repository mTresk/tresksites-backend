<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Work extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'label', 'url', 'list', 'content', 'is_featured'];

    protected $casts = ['content' => 'array', 'is_featured' => 'boolean'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('featured')
            ->performOnCollections('featured')
            ->fit(Fit::Contain, 1058)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('featuredWebp')
            ->performOnCollections('featured')
            ->format('webp')
            ->fit(Fit::Contain, 1058)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('featured@2')
            ->performOnCollections('featured')
            ->fit(Fit::Contain, 2116)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('featuredWebp@2')
            ->performOnCollections('featured')
            ->format('webp')
            ->fit(Fit::Contain, 2116)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('work')
            ->performOnCollections('works')
            ->fit(Fit::Contain, 1000)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('workWebp')
            ->performOnCollections('works')
            ->format('webp')
            ->fit(Fit::Contain, 1000)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('work@2')
            ->performOnCollections('works')
            ->fit(Fit::Contain, 2000)
            ->nonQueued()
            ->nonOptimized();

        $this->addMediaConversion('workWebp@2')
            ->performOnCollections('works')
            ->format('webp')
            ->fit(Fit::Contain, 2000)
            ->nonQueued()
            ->nonOptimized();
    }


    protected function setContent(): Attribute
    {
        $media = $this->getMedia('works');
        $content = [];

        foreach ($this->content as $item) {
            foreach ($media as $image) {
                if (isset($item['data']['gallery_id'])) {
                    if ($item['data']['gallery_id'] == $image->custom_properties['gallery_id']) {
                        $item['data']['images'] = [
                            'image' => $image->getUrl('work'),
                            'imageWebp' => $image->getUrl('workWebp'),
                            'imageX2' => $image->getUrl('work@2'),
                            'imageWebpX2' => $image->getUrl('workWebp@2')];
                        $content[] = $item;
                    }
                } else {
                    $content[] = $item;
                }
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
            $image->featured = $image->getUrl('featured');
            $image->featuredWebp = $image->getUrl('featuredWebp');
            $image->featuredX2 = $image->getUrl('featured@2');
            $image->featuredWebpX2 = $image->getUrl('featuredWebp@2');
            $images = $image;
        }

        return Attribute::make(
            get: fn() => $images,
        );
    }
}
