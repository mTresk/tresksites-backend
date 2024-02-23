<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SEO extends Model
{
    protected $fillable = ['title', 'description'];

    public $table = 'seo';

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
