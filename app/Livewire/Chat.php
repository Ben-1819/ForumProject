<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;

use App\Events\MessageSentEvent;

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
        $this->user = $this->getUser($userId);

        $this->senderId = Auth::user()->id;

        $this->receiverId = $userId;

        $this->messages = $this->getMessages();
    }
    public function render()
    {
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
        $sentMessage= $this->saveMessage();

        $this->messages[] = $sentMessage;

        broadcast(new MessageSentEvent($sentMessage));

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
}
