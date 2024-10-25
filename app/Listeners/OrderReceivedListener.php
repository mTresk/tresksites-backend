<?php

namespace App\Listeners;

use App\Events\OrderReceivedEvent;
use App\Notifications\EmailOrderNotification;
use App\Notifications\TelegramOrderNotification;

class OrderReceivedListener
{
    public function handle(OrderReceivedEvent $event): void
    {
        $event->order->notify(new TelegramOrderNotification());
        $event->order->notify(new EmailOrderNotification());
    }
}
