<?php

namespace App\Http\Controllers;

use App\Models\Replies;
use App\Http\Requests\PostReplyRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(PostReplyRequest $request, $id){
        log::info("Validate the users reply");
        $newReply = $request->validated();

        log::info("Add the id of the comment and the id of the user into the reply");
        $newReply["comment_id"] = $request->comment_id;
        $newReply["user_id"] = Auth::user()->id;

        log::info("save the new reply");
        $reply = new Replies($newReply);
        $reply->save();

        log::info("Reply Saved!");
        log::info("Comment replied to: {comment_id}", ["comment_id" => $reply->comment_id]);
        log::info("User who replied: {user_id}", ["user_id" => $reply->user_id]);
        log::info("Contents of reply: {contents}", ["contents" => $reply->contents]);

        log::info("Return to previous view with success message");
        return redirect()->back()->with("ReplyMessage", "Reply successfully created");
    }
}
