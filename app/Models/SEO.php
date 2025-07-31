<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class SEO extends Model
{
    public $table = 'seo';

    protected $fillable = [
        'title',
        'description',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
