<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'attachment',
    ];
}
