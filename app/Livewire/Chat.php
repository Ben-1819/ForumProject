<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;

use App\Events\MessageSentEvent;
use App\Events\UnreadMessage;
use App\Events\UserTyping;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public $user;
    public $message;
    public $senderId;
    public $receiverId;
    public $messages = [];

    public function mount($userId){
        $this->dispatch("messages-updated");
        $this->user = $this->getUser($userId);

        $this->senderId = Auth::user()->id;

        $this->receiverId = $userId;

        $this->messages = $this->getMessages();

        $this->markMessagesAsRead();
    }
    public function render()
    {
        $this->markMessagesAsRead();

        return view('livewire.chat');
    }

    public function getUser($userId){
        log::info("Return the record from the users table where the id matches the one passed");
        return User::find($userId);
    }

    public function getMessages(){
        return Message::with("sender", "receiver")
            ->where(function($query){
                $query->where("sender_id", $this->senderId)
                    ->where("receiver_id", $this->receiverId);
            })
            ->orWhere(function($query){
                $query->where("sender_id", $this->receiverId)
                    ->where("receiver_id", $this->senderId);
            })
            ->get();
    }

    public function sendMessage(){
        $sentMessage = $this->saveMessage()->load("sender:id,username", "receiver:id,username");

        $this->messages[] = $sentMessage;

        broadcast(new MessageSentEvent($sentMessage));

        $unreadCount = $this->getUnreadMessagesCount();

        broadcast(new UnreadMessage($this->receiverId, $this->senderId, $unreadCount));

        $this->message = null;

        $this->dispatch("messages-updated");
    }

    public function saveMessage(){
        log::info("Save a new record in the messages table");
        log::info("Message sender: {senderId}", ["senderId" => $this->senderId]);
        log::info("Message receiver: {receiverId}", ["receiverId" => $this->receiverId]);
        log::info("Message contents: {message}", ["message" => $this->message]);
        return Message::create([
            "sender_id" => $this->senderId,
            "receiver_id" => $this->receiverId,
            "message" => $this->message,
            "is_read" => false,
        ]);
    }

    #[On("echo-private:chat-channel.{senderId},MessageSentEvent")]
    public function listenMessage($event){
        $newMessage = Message::find($event["message"]["id"])->load("sender:id,username", "receiver:id,username");

        $this->messages[] = $newMessage;
    }

    public function getUnreadMessagesCount(){
        return Message::where("receiver_id", $this->receiverId)
            ->where("is_read", "false")
            ->count();
    }

    public function markMessagesAsRead(){
        Message::where("receiver_id", $this->senderId)
            ->where("sender_id", $this->receiverId)
            ->where("is_read", false)
            ->update(["is_read" => true]);

        broadcast(new UnreadMessage($this->senderId, $this->receiverId, 0))->toOthers();
    }

    public function userTyping() {
        broadcast(new UserTyping($this->senderId, $this->receiverId))->toOthers();
    }
}
