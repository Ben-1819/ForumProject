<?php

namespace App\Http\Controllers;

use App\Models\Comment;

use App\Http\Requests\StoreCommentRequest;
use App\Events\CommentPosted;
use Event;
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

        Event::dispatch(new CommentPosted($comment->post, $comment));
        log::info("Returning to viewing the post");
        return redirect()->route("post.show", ["id" => $comment->post_id])->with("CommentMessage", "Comment added to post");
    }

    public function destroy($id){
        log::info("Deleting comment with id of: {id}", ["id" => $id]);
        Comment::find($id)->delete();
        log::info("Comment Deleted");
        return redirect()->back()->with("CommentMessage", "Comment removed from post");
    }

    public function show($id){
        log::info("Show the comment and all of its replies");
        $comment = Comment::with("replies")->find($id);

        log::info("Return comment show view");
        return view("comment.show", compact("comment"));
    }
}
