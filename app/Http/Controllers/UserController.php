<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        log::info("Get a list of all users aside from the current user");
        $all_users = User::where("id", "!=", request()->user()->id)->get();

        log::info("Return the user index view");
        return view("user.index", compact("all_users"));
    }

    public function show($id){
        log::info("Get the record belonging to the selected user");
        $user = User::with("posts")->find($id);

        log::info("Return the user.show view");
        return view("profile.show", compact("user"));
    }

    public function delete($id){
        log::info("Deleting the user with the selected id");
        User::find($id)->delete();

        log::info("User deleted");
        return redirect()->back();
    }
}
