<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

final class EmailOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(Order $order): MailMessage
    {
        $mail = (new MailMessage())
            ->subject('Получено сообщение с сайта '.config('app.name'))
            ->markdown('mail.order', ['order' => $order]);

        if ($order->attachment) {
            $mail->attach(Storage::disk('local')->path($order->attachment));
        }

        return $mail;
    }
}
