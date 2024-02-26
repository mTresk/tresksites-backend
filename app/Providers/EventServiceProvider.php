<?php

namespace App\Providers;

use App\Events\OrderReceivedEvent;
use App\Listeners\OrderReceivedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderReceivedEvent::class => [
            OrderReceivedListener::class
        ]
    ];

    public function boot(): void
    {
        //
    }
    
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
