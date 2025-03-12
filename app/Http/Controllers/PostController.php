<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_posts = Post::all();

        return view("post.index", compact("all_posts"));
    }

    public function friendPosts(){
        $all_friends = Friend::where("user1_id", request()->user()->id)->orWhere("user2_id", request()->user()->id)
            ->where("status", "accepted")
            ->get();

        $friends_posts = collect();
        foreach($all_friends as $friend){
            $friend_posts = Post::whereIn('user_id', [$friend->user1_id, $friend->user2_id])
                ->where("user_id", "!=", request()->user()->id)
                ->get();

            $friends_posts = $friends_posts->merge($friend_posts);
        }
        return view("post.friend-index", compact("friends_posts", "all_friends"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        log::info("Redirecting the user to the post create view");
        return view("post.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        log::info("Validate the users input");
        $postInput = $request->validated();

        log::info("Set the user Id for the post");
        $postInput["user_id"] = request()->user()->id;

        log::info("Save the new post");
        $post = new Post($postInput);
        $post->save();

        log::info("Go to the post show page");

        return redirect()->route("dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        log::info("Get the record from the posts table where the id matches");
        $post = Post::find($id);

        log::info("Return post show view");
        return view("post.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
