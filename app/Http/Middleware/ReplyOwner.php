<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Replies;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpFoundation\Response;

class ReplyOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        log::info("Get the id of the reply using route parameters");
        $replyId = $request->route("id");

        log::info("Find the record in the replies table that matches the id");
        $reply = Replies::with("comment", "user")->find($replyId);

        log::info("Check if the user is the creator of the post, the creator of the reply or a superadmin");

        if(Auth::user()->id === $reply->user_id || Auth::user()->id === $reply->comment->post->user_id){
            return $next($request);
        }
        elseif(request()->user()->hasRole("superadmin")){
            return $next($request);
        }
        else{
            abort(403, "Not authorised to access this page");
        }
    }
}
