<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'description'];

    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMedia('services')->original_url,
        );
    }
}
