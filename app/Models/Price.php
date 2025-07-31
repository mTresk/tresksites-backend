<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Price extends Model
{
    protected $fillable = [
        'title',
        'description',
        'block',
    ];

    protected $casts = [
        'block' => 'array',
    ];
}
