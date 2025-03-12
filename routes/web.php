<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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


require __DIR__.'/auth.php';
