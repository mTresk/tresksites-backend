<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SEO extends Model
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
