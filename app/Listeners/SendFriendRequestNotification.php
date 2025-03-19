<?php

namespace App\Listeners;
use App\Notifications\FriendRequestNotification;
use App\Events\FriendRequest;
use Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFriendRequestNotification
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
    public function handle(FriendRequest $event): void
    {
        Notification::send($event->user, new FriendRequestNotification($event->user));
    }
}
