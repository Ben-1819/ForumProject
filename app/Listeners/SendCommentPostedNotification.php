<?php

namespace App\Listeners;

use App\Notifications\CommentPostedNotification;
use App\Events\CommentPosted;
use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentPostedNotification
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
    public function handle(CommentPosted $event): void
    {
        Notification::send($event->post->user, new CommentPostedNotification($event->post, $event->comment));
    }
}
