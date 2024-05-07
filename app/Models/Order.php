<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'phone', 'email', 'message', 'attachment'];
}
