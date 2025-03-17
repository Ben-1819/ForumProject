<?php

namespace App\Http\Controllers;

use App\Models\Comment;

use App\Http\Requests\StoreCommentRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $id){
        log::info("Validate the users input");

        $commentInput = $request->validated();

        log::info("Add the post id and the user id");
        $commentInput["post_id"] = $request->post_id;
        $commentInput["user_id"] = Auth::user()->id;

        log::info("post_id: {post_id}", ["post_id" => $request->post_id]);
        log::info("User id: {user_id", ["user_id" => Auth::user()->id]);
        log::info("Create new comment");
        $comment = new Comment($commentInput);
        $comment->save();

        log::info("New comment created");
        log::info("Post commented on: {post_id}", ["post_id" => $comment->post_id]);
        log::info("User that commented: {uder_id}", ["user_id" => $comment->user_id]);
        log::info("Comment contents: {comment}", ["comment" => $comment]);

        log::info("Returning to viewing the post");
        return redirect()->route("post.show", ["id" => $comment->post_id]);
    }
}
