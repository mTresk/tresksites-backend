<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Получено сообщение с сайта '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order',
        );
    }

    public function attachments(): array
    {
        if (isset($this->order['attachment'])) {
            return [
                Attachment::fromStorageDisk('public', $this->order['attachment'])
            ];
        } else {
            return [];
        }
    }
}
