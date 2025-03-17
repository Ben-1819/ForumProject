<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatIndex(){
        log::info("Get all records from the messages table where sender_id is the same as the current user or receiver_id is the same as the current user");
        $users = User::where("id", "!=", Auth::user()->id)->withCount(["unreadMessages"])->get();

        log::info("Return the conversations view");
        return view("messaging.conversations", compact("users"));
    }

    public function userChat($userId){
        return view("messaging.user-chat", compact("userId"));
    }
}
