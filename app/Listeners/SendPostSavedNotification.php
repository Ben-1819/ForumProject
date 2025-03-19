<?php

namespace App\Listeners;

use App\Events\PostSaved;
use App\Notifications\PostSavedNotification;
use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPostSavedNotification
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
    public function handle(PostSaved $event): void
    {
        Notification::send($event->post->user, new PostSavedNotification($event->post, $event->saveUser));
    }
}
