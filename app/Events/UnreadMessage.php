<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnreadMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $receiverId;
    public $senderId;
    public $unreadCount;
    public function __construct($receiverId, $senderId, $unreadCount)
    {
        $this->receiverId = $receiverId;
        $this->senderId = $senderId;
        $this->unreadCount = $unreadCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('unread-channel.'. $this->receiverId),
        ];
    }

    public function broadcastWith()
    {
        return[
            "unreadCount" => $this->unreadCount,
            "senderId" => $this->senderId,
            "receiverId" => $this->receiverId,
        ];
    }
}
