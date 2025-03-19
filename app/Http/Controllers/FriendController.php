<?php

namespace App\Http\Controllers;

use App\Events\FriendRequest;
use Event;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FriendController extends Controller
{
    /**
     * Show all of the users friends.
     */
    public function index()
    {
        log::info("Get all records from the friends table where user1_id is the same as the current user and the request is accepted");
        $all_friends = Friend::where("user1_id", request()->user()->id)->orWhere("user2_id", request()->user()->id)
            ->where("status", "accepted")
            ->get();

        log::info("Return the friend index view");
        return view("friend.index", compact("all_friends"));
    }

    /**
     * View all incoming friend requests
     */
    public function requests(){
        log::info("Get all records from the friend table where user2_id is the same as the current user and the request is pending");
        $all_requests = Friend::where("user2_id", request()->user()->id)->where("status", "pending")->get();

        log::info("Return the friend requests view");
        return view("friend.requests", compact("all_requests"));
    }

    /**
     * Send a friend request to another user
     */
    public function sendRequest($id){
        log::info("Creating friend request");

        log::info("Find the record in the users table belonging to the user recieving the request");
        $user = User::find($id);

        log::info("If the users account is public accepct the request, if it is not then leave it as pending");
        if($user->public == true){
            $friend = new Friend([
                "user1_id" => request()->user()->id,
                "user2_id" => $id,
                "status" => "accepted",
            ]);
            $friend->save();
            log::info("Friend Added");
            return back()->with("Message", "Friend Request Sent");
        }
        else{
            $friend = new Friend([
                "user1_id" => request()->user()->id,
                "user2_id" => $id
            ]);
            $friend->save();
            log::info("Friend request sent");
            Event::dispatch(new FriendRequest($user));

            return back()->with("Message", "Friend Request Sent");
        }
    }

    /**
     * Accept an incoming friend request
     */
    public function acceptRequest($id){
        log::info("Change the status of the friend request to accepted");
        $update_friend = Friend::where("id", $id)->update([
            "status" => "accepted",
        ]);
        log::info("Friend request accepted");

        return back()->with("Message", "Friend Request Accepted");
    }

    /**
     * Reject an incoming friend request
     */
    public function rejectRequest($id){
        log::info("Delete the incoming friend request");
        Friend::where("id", $id)->delete();
        log::info("Friend request rejected");

        return back()->with("Message", "Friend Request Rejected");
    }

    /**
     * Add a friend to favourites
     */
    public function addFavourite($id){
        log::info("Updating the selected record from the friends table to have favourite as true");
        $update_friend = Friend::where("id", $id)->update([
            "favourite" => true,
        ]);

        return redirect()->back()->with("Message", "Friend Set To Favourite");
    }

    /**
     * Remove a friend from favourites
     */
    public function removeFavourite($id){
        log::info("Updating the selected record from the friends table to have favourite as false");
        $update_friend = Friend::where("id", $id)->update([
            "favourite" => false,
        ]);

        return redirect()->back()->with("Message", "Friend is not Favourite Anymore");
    }

    /**
     * Show all favourited friends
     */
    public function favourites(){
        log::info("Returning all records from the friends table where either user_ids match the current users_id and favourite is true");
        $all_favourites = Friend::where("user1_id", request()->user()->id)->orWhere("user2_id", request()->user()->id)
            ->where("favourite", true)
            ->get();

        log::info("Returning to the favourites view");
        return view("friend.favourite", compact("all_favourites"));
    }

    /**
     * Remove friends
     */
    public function removeFriend($id){
        log::info("Delete record from the friends table where the id matches");
        Friend::where("id", $id)->delete();

        log::info("Friend removed");
        return redirect()->back()->with("Friend Removed");
    }
}
