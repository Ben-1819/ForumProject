<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpFoundation\Response;

class PostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $postId = $request->route("id");
        log::info("Find the record in the post table where the id matches");
        $post = Post::with("user")->find($postId);

        log::info("Check if the current user is the owner of the post or a superadmin");
        if(Auth::user()->id === $post->user->id || request()->user()->hasRole("superadmin")){
            return $next($request);
        }
        else{
            log::info("Current ser is not authorised");
            abort(403, "Not authorised to access this page");
        }
    }
}
