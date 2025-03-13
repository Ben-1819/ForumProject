<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Save;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function savePost($id){
        log::info("Create a new record in the save table for the saved post");

        $save = new Save([
            "post_id" => $id,
            "user_id" => request()->user()->id,
        ]);
        $save->save();

        log::info("Post saved");
        return redirect()->back();
    }

    public function unsavePost($id){
        log::info("Delete the record that contains the saved post for the current user in the saves table");

        Save::where("post_id", $id)->where("user_id", request()->user()->id)->delete();

        log::info("Record deleted from the saves table");
        return redirect()->back();
    }
}
