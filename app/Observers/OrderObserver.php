<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class OrderObserver
{

    public function updated(Order $order): void
    {
        if ($order->isDirty('attachment')) {
            Storage::disk('public')->delete($order->getOriginal('attachment'));
        }
    }

    public function deleted(Order $order): void
    {
        if (!is_null($order->attachment)) {
            Storage::disk('public')->delete($order->attachment);
        }
    }
}
