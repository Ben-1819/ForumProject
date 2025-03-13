<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix("/profile")->name("profile.")->controller(ProfileController::class)->group(function () {
    Route::get('', "edit")->name('edit');
    Route::get("/show", "show")->name("show");
    Route::get("/show/yours", "showYours")->name("showYours");
    Route::get("/bio", "editBio")->name("editBio");
    Route::get("/picture", "editPicture")->name("editPicture");
    Route::patch("/picture/delete", "updatePicture")->name("updatePicture");
    Route::patch("/bio/{id}", "updateBio")->name("updateBio");
    Route::patch('', "update")->name('update');
    Route::delete('', "destroy")->name('destroy');
});

Route::name("user.")->prefix("/user")->controller(UserController::class)->group(function(){
    Route::get("/index", "index")->name("index");
    Route::get("/{id}", "show")->name("show");
});

Route::name("friend.")->prefix("/friend")->controller(FriendController::class)->group(function(){
    Route::get("/index", "index")->name("index");
    Route::get("/favourites", "favourites")->name("favourites");
    Route::patch("/add/favourite/{id}", "addFavourite")->name("addFavourite");
    Route::patch("/remove/favourite/{id}", "removeFavourite")->name("removeFavourite");
    Route::post("/request/{id}", "sendRequest")->name("request");
    Route::get("/requests", "requests")->name("requests");
    Route::patch("/accept/{id}", "acceptRequest")->name("accept");
    Route::patch("/reject/{id}", "rejectRequest")->name("reject");
    Route::delete("/remove/{id}", "removeFriend")->name("remove");
});

Route::name("post.")->prefix("/post")->controller(PostController::class)->group(function(){
    Route::get("/index", "index")->name("index");
    Route::get("/friends", "friendPosts")->name("friendsPosts");
    Route::get("/create", "create")->name("create");
    Route::post("", "store")->name("store");
    Route::get("/{id}/show", "show")->name("show");
    Route::get("/{id}/edit", "edit")->name("edit");
    Route::put("/{id}", "update")->name("update");
    Route::delete("/{id}", "destroy")->name("destroy");
});

Route::name("like.")->prefix("/like")->controller(LikeController::class)->group(function(){
    Route::put("/{id}", "likePost")->name("add");
    Route::delete("/{id}", "removeLike")->name("remove");
    Route::get("/user", "yourLikes")->name("yours");
});

Route::name("save.")->prefix("/save")->controller(SaveController::class)->group(function(){
    Route::post("/{id}", "savePost")->name("post");
    Route::delete("/{id}", "unsavePost")->name("remove");
});

require __DIR__.'/auth.php';
