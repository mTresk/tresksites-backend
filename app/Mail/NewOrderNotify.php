<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderNotify extends Mailable
{
    use Queueable, SerializesModels;

    public object $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Получено сообщение с сайта ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order',
            with: ['mailData' => $this->order]
        );
    }

    public function attachments(): array
    {
        if (isset($this->order['attachment'])) {
            return [
                Attachment::fromStorage('/public/' . $this->order['attachment'])
            ];
        } else return [];
    }
}
