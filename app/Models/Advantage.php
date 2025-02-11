<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    protected $fillable = [
        'block'
    ];

    protected $casts = [
        'block' => 'array'
    ];
}
