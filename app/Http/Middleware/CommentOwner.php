<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CommentOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        log::info("Get the id passed in the route");
        $commentId = $request->route("id");

        log::info("Get the record from the comments table where the id matches");
        $comment = Comment::with("user", "post")->find($commentId);

        log::info("Check if the user is the post owner, the comment owner or a superadmin");
        if(Auth::user()->id === $comment->user_id || Auth::user()->id === $comment->post->user_id){
            return $next($request);
        }
        elseif(request()->user()->hasRole("superadmin")){
            return $next($request);
        }
        else{
            abort(403, "Not authorised to do this");
        }
    }
}
