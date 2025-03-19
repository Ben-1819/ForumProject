<?php

namespace App\Http\Controllers;

use App\Events\PostLiked;
use Event;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
            "user_id" => $post->user_id,
            "title" => $post->title,
            "description" => $post->description,
            "likes" => $total,
        ];

        $updatePost = Post::where("id", $like->post_id)->update($newPost);

        log::info("Post Likes:". $total);
        return redirect()->back()->with("LikeMessage", "Post Added To Liked Posts");
    }

    public function removeLike($id){
        log::info("Delete the record in the likes table containing the users like");

        Like::where("post_id", $id)->where("user_id", request()->user()->id)->delete();

        log::info("Like deleted");

        $post = Post::find($id);
        $total = 0;
        log::info("Loop through the likes table and get the total amount of likes on the post");
        $likes = Like::where("post_id", $id)->get();
        $total = count($likes);
        log::info("total likes: {likes}", ["likes" => $total]);

        $newPost = [
            "user_id" => $post->user_id,
            "title" => $post->title,
            "description" => $post->description,
            "likes" => $total,
        ];

        $updatePost = Post::where("id", $id)->update($newPost);

        log::info("Post Likes:". $total);
        return redirect()->back()->with("LikeMessage", "Post Removed From Liked Posts");
    }

    public function yourLikes(){
        log::info("Get all records from the likes table where the user_id is the same as the current users");
        $users_likes = Like::with("post", "user")->where("user_id", request()->user()->id)
            ->paginate();

        log::info("Return view users likes");
        return view("like.user", compact("users_likes"));
    }
}
