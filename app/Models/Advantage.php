<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Advantage extends Model
{
    protected $fillable = [
        'block',
    ];

    protected $casts = [
        'block' => 'array',
    ];
}
