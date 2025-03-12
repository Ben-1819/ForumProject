<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
    public function show(Post $post)
    {
        //
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
