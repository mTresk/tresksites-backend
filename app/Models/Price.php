<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['title', 'description', 'block'];

    protected $casts = ['block' => 'array'];
}
