<?php

namespace App\Listeners;

use App\Notifications\ReplyPostedNotification;
use App\Events\CommentReply;
use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReplyPostedNotification
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
    public function handle(CommentReply $event): void
    {
        Notification::send($event->user, new ReplyPostedNotification($event->reply));
    }
}
