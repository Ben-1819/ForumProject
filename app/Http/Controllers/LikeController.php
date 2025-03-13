<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likePost($id){
        log::info("Create a record in the likes table for the post with the id passed");

        $like = new Like([
            "post_id" => $id,
            "user_id" => request()->user()->id,
        ]);
        $like->save();

        log::info("Post: ". $like->post_id ."has been liked by user: ". $like->user_id);
        log::info("Return to the post show page");

        $post = Post::find($like->post_id);
        $total = 0;
        log::info("Loop through the likes table and get the total likes for this post");
        $likes = Like::where("post_id", $post->id)->get();
        foreach($likes as $each){
            $total += 1;
        }
        log::info("Post has: {likes}", ["likes" => $total]);
        $newPost = [
            "user_id" => $post->id,
            "title" => $post->title,
            "description" => $post->description,
            "likes" => $total,
        ];

        $updatePost = Post::where("id", $like->post_id)->update($newPost);

        log::info("Post Likes:". $total);
        return redirect()->back();
    }
}
