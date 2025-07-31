<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class Contact extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'inn',
        'block',
        'email',
        'telegram',
    ];

    protected $casts = [
        'block' => 'array',
    ];

    protected function brief(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia(collectionName: 'files')->original_url,
        );
    }
}
