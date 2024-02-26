<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(): array
    {
        return ["telegram"];
    }

    public function toTelegram($order)
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.chat_id'))
            ->view('telegram.order', ['order' => $order]);
    }
}
