<?php

namespace App\Listeners;
use App\Events\PostLiked;
use App\Notifications\PostLikedNotification;
use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPostLikedNotification
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
    public function handle(PostLiked $event): void
    {
        Notification::send($event->post->user, new PostLikedNotification($event->post, $event->likeUser));
    }
}
