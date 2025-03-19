<?php

namespace App\Listeners;

use App\Events\PostUpdated;
use App\Notifications\PostUpdatedNotification;
use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPostUpdatedNotification
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
    public function handle(PostUpdated $event): void
    {
        Notification::send($event->post->user, new PostUpdatedNotification($event->post));
    }
}
