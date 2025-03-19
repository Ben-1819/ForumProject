<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\PostOwner;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ChatController::class)->group(function(){
    Route::get("/chats", "chatIndex")->name("chats");
    Route::get("/chat/{id}", "userChat")->name("chat");
    Route::delete("/chats/{id}/archive", "archiveChats")->name("archive");
    Route::get("/chats/archived", "archivedIndex")->name("archived.index");
    Route::patch("/chats/{id}/restore", "restoreChats")->name("restoreArchived");
    Route::delete("/chats/{id}/delete", "deleteArchived")->name("deleteArchived");
});

Route::middleware('auth')->prefix("/profile")->name("profile.")->controller(ProfileController::class)->group(function () {
    Route::get('', "edit")->name('edit');
    Route::get("/show/{id}", "show")->name("show");
    Route::get("/show/{id}/yours", "showYours")->name("showYours");
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
    Route::delete("/reject/{id}", "rejectRequest")->name("reject");
    Route::delete("/remove/{id}", "removeFriend")->name("remove");
})->middleware(["auth", "verified"]);

Route::name("post.")->prefix("/post")->controller(PostController::class)->group(function(){
    Route::get("/index", "index")->name("index");
    Route::get("/friends", "friendPosts")->name("friendsPosts");
    Route::get("/create", "create")->name("create");
    Route::post("", "store")->name("store");
    Route::get("/{id}/show", "show")->name("show");
    Route::get("/{id}/edit", "edit")->name("edit")->middleware(["PostOwner"]);
    Route::put("/{id}", "update")->name("update")->middleware(["PostOwner"]);
    Route::delete("/{id}", "destroy")->name("destroy")->middleware(["PostOwner"]);
    Route::get("/{id}/likes", "likesByPost")->name("byPost");
    Route::get("/{id}/saved", "whoSavedPost")->name("whoSaved")->middleware(["PostOwner"]);
});

Route::name("like.")->prefix("/like")->controller(LikeController::class)->group(function(){
    Route::put("/{id}", "likePost")->name("add");
    Route::delete("/{id}", "removeLike")->name("remove");
    Route::get("/user", "yourLikes")->name("yours");
})->middleware(["auth", "verified"]);

Route::name("save.")->prefix("/save")->controller(SaveController::class)->group(function(){
    Route::post("/{id}", "savePost")->name("post");
    Route::delete("/{id}", "unsavePost")->name("remove");
    Route::get("/user", "yourSaves")->name("yours");
})->middleware(["auth", "verified"]);

Route::name("comment.")->prefix("/comment")->controller(CommentController::class)->group(function(){
    Route::post("/{id}", "store")->name("store");
    Route::delete("/{id}", "destroy")->name("delete")->middleware(["CommentOwner"]);
    Route::get("/{id}/show", "show")->name("show");
})->middleware(["auth", "verified"]);

Route::name("reply.")->prefix("/reply")->controller(ReplyController::class)->group(function(){
    Route::post("/{id}", "store")->name("store");
    Route::delete("'/{id}", "destroy")->name("delete");
})->middleware(["auth", "verified"]);
require __DIR__.'/auth.php';
