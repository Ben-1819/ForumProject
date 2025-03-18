<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatIndex(){
        log::info("Get the id of the current user");
        $userId = Auth::user()->id;

        $chats = Message::where(function ($query) use ($userId){
            $query->where("sender_id", $userId)
                ->orWhere("receiver_id", $userId);
        })
        ->with("sender", "receiver")
        ->get()
        ->groupBy(function($message) use ($userId){
            return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
        })
        ->map(function($messages){
            return $messages->sortByDesc("created_at")->first();
        });
        return view("messaging.conversations", compact("chats"));
    }

    public function userChat($userId){
        return view("messaging.user-chat", compact("userId"));
    }
}
