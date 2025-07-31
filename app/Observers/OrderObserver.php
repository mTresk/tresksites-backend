<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;

final class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->isDirty('attachment')) {
            Storage::disk('local')->delete($order->getOriginal('attachment'));
        }
    }

    public function deleted(Order $order): void
    {
        if (! is_null($order->attachment)) {
            Storage::disk('local')->delete($order->attachment);
        }
    }
}
