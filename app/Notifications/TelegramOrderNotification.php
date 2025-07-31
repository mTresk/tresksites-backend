<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

final class TelegramOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(): array
    {
        return ['telegram'];
    }

    public function toTelegram(Order $order)
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.chat_id'))
            ->view('telegram.order', ['order' => $order]);
    }
}
