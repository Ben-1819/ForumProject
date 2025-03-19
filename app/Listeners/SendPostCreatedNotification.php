<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\PostCreatedNotification;
use Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPostCreatedNotification
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
    public function handle(PostCreated $event): void
    {
        Notification::send($event->post->user, new PostCreatedNotification($event->post));
    }
}
