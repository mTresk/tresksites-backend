<?php

namespace App\Listeners;

use App\Events\OrderReceivedEvent;
use App\Mail\NewOrderNotify;
use App\Notifications\TelegramOrderNotification;
use Illuminate\Support\Facades\Mail;

class OrderReceivedListener
{
    public function handle(OrderReceivedEvent $event): void
    {
        Mail::to(config('services.admin-email'))->queue(new NewOrderNotify($event->order));
        $event->order->notify(new TelegramOrderNotification($event->order));
    }
}
