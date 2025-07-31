<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderReceived;
use App\Notifications\EmailOrderNotification;
use App\Notifications\TelegramOrderNotification;

final class OrderReceivedListener
{
    public function handle(OrderReceived $event): void
    {
        $event->order->notify(new TelegramOrderNotification());
        $event->order->notify(new EmailOrderNotification());
    }
}
