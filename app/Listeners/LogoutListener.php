<?php

namespace App\Listeners;

use App\Services\RconService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogoutListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if(!$event->user || !$event->user->online) return;

        $rcon = app(RconService::class);
        $rcon->sendSafely('disconnectUser', [$event->user]);
    }
}
