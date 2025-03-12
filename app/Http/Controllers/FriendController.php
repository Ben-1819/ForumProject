<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
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

    public function requests(){
        log::info("Get all records from the friend table where user2_id is the same as the current user and the request is pending");
        $all_requests = Friend::where("user2_id", request()->user()->id)->where("status", "pending")->get();

        log::info("Return the friend requests view");
        return view("friend.requests", compact("all_requests"));
    }
    public function sendRequest($id){
        log::info("Creating friend request");
        $friend = new Friend([
            "user1_id" => request()->user()->id,
            "user2_id" => $id
        ]);
        $friend->save();

        log::info("Friend request sent");
        return back()->with("Message", "Friend Request Sent");
    }

    public function acceptRequest($id){
        log::info("Change the status of the friend request to accepted");
        $update_friend = Friend::where("id", $id)->update([
            "status" => "accepted",
        ]);
        log::info("Friend request accepted");

        return back()->with("Message", "Friend Request Accepted");
    }

    public function rejectRequest($id){
        log::info("Change the status of the friend request to rejected");
        $update_friend = Friend::where("id", $id)->update([
            "status" => "rejected",
        ]);
        log::info("Friend request rejected");

        return back()->with("Message", "Friend Request Rejected");
    }

    public function addFavourite($id){
        log::info("Updating the selected record from the friends table to have favourite as true");
        $update_friend = Friend::where("id", $id)->update([
            "favourite" => true,
        ]);

        return redirect()->back()->with("Message", "Friend Set To Favourite");
    }

    public function removeFavourite($id){
        log::info("Updating the selected record from the friends table to have favourite as false");
        $update_friend = Friend::where("id", $id)->update([
            "favourite" => false,
        ]);

        return redirect()->back()->with("Message", "Friend is not Favourite Anymore");
    }

    public function favourites(){
        log::info("Returning all records from the friends table where either user_ids match the current users_id and favourite is true");
        $all_favourites = Friend::where("user1_id", request()->user()->id)->orWhere("user2_id", request()->user()->id)
            ->where("favourite", true)
            ->get();

        log::info("Returning to the favourites view");
        return view("friend.favourite", compact("all_favourites"));
    }
    /**
     * Display the specified resource.
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friend $friend)
    {
        //
    }
}
