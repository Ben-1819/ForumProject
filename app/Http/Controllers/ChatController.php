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

    public function archivedIndex(){
        log::info("Get the id of the current user");
        $userId = Auth::user()->id;

        log::info("Retrieve all of the users archived chats");
        $chats = Message::withTrashed()
            ->whereNotNull("deleted_at")
            ->where(function($query) use ($userId){
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

            return view("messaging.archived", compact("chats"));
    }

    public function userChat($userId){
        return view("messaging.user-chat", compact("userId"));
    }

    public function archiveChats($user_id)
    {
        log::info("Getting the id of the current user");
        $userId = Auth::user()->id;

        log::info("Archiving all chats between the selected user and the current user");
        Message::with("sender", "receiver")
            ->where("sender_id", $userId)
            ->where("receiver_id", $user_id)
            ->orWhere("sender_id", $user_id)->where("receiver_id", $userId)
            ->delete();

        log::info("chats archived, returning to conversations view");
        return redirect()->back();
    }

    public function restoreChats($user_id)
    {
        log::info("Getting the id of the current user");
        $userId = Auth::user()->id;

        log::info("Restoring all archived chats between the selected user and the current user");
        Message::with("sender", "receiver")
            ->withTrashed()
            ->whereNotNull("deleted_at")
            ->where("sender_id", $userId)
            ->where("receiver_id", $user_id)
            ->orWhere("sender_id", $user_id)->where("receiver_id", $userId)->whereNotNull("deleted_at")
            ->restore();

        return redirect()->back()->with("message", "Chats Restored Successfully");
    }

    public function deleteArchived($user_id){
        log::info("Get the id of the current user");
        $userId = Auth::user()->id;

        log::info("Deleting all archived chats between the current user and the selected user");
        Message::with("sender", "receiver")
            ->withTrashed()
            ->whereNotNull("deleted_at")
            ->where("sender_id", $userId)
            ->where("receiver_id", $user_id)
            ->orWhere("sender_id", $user_id)->where("receiver_id", $userId)->whereNotNull("deleted_at")
            ->forceDelete();
        return redirect()->back()->with("message", "Chats permanently deleted");
    }
}
