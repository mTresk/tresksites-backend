<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderReceivedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public object $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
}
