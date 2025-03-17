@php
    use App\Models\User;
    use App\Models\Like;
    use App\Models\Save;
    $user = User::find($post->user_id);
    $users_likes = Like::where("user_id", request()->user()->id)->get();
    if(count($users_likes) > 0){
        foreach($users_likes as $like){
            if($like->post_id == $post->id){
                $liked = true;
                break;
            }
            else{
                $liked = false;
            }
        }
    }
    else{
        $liked = false;
    }

    $users_saves = Save::where("user_id", request()->user()->id)->get();
    if(count($users_saves) > 0){
        foreach($users_saves as $save){
            if($save->post_id == $post->id){
                $saved = true;
                break;
            }
            else{
                $saved = false;
            }
        }
    }
    else{
        $saved = false;
    }
@endphp
<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Post Header -->
        <div class="flex items-center space-x-4 mb-6">
            <!-- Profile Picture -->
            <img src="/avatars/{{$user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full">

            <!-- User Info -->
            <div>
                <p class="font-semibold text-gray-800">{{$user->username}}</p>
            </div>
        </div>

        <!-- Post Title -->
        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{$post->title}}</h2>

        <!-- Post Content -->
        <p class="text-lg text-gray-700 mb-6 break-words">
            {{$post->description}}
        </p>

        <!-- Post Footer -->
        <div class="flex items-center justify-between text-sm text-gray-500">
            <p>{{$post->created_at}}</p>

            <!-- Likes -->
            <div class="flex items-center space-x-2">
                @if($liked == false)
                <form action="{{route("like.add", $post->id)}}" method="post">
                    @csrf
                    @method("put")
                    <button>
                        <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" onclick="this.form.submit()">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 3.498c.3-1.057 1.804-1.057 2.105 0l1.173 3.727c.196.634.757 1.035 1.411 1.035h3.897c1.076 0 1.52 1.372.728 2.054l-3.15 2.43c-.415.318-.588.87-.459 1.41l1.07 3.89c.283 1.035-.876 1.9-1.754 1.343l-3.441-2.558c-.532-.391-1.221-.347-1.67.141l-3.11 3.647c-.81.957-2.394.363-2.396-1.023v-3.723c0-.543-.217-1.063-.608-1.454l-3.125-3.267c-1.019-.868-.499-2.474.918-2.474h3.845c.736 0 1.4-.471 1.643-1.163l1.18-3.637z"/>
                        </svg>
                    </button>
                    <span>{{$post->likes}}</span>
                </form>
                @else
                <form action="{{route("like.remove", $post->id)}}" method="post">
                    @csrf
                    @method("delete")
                    <button>
                        <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke="currentColor" onclick="this.form.submit()">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 3.498c.3-1.057 1.804-1.057 2.105 0l1.173 3.727c.196.634.757 1.035 1.411 1.035h3.897c1.076 0 1.52 1.372.728 2.054l-3.15 2.43c-.415.318-.588.87-.459 1.41l1.07 3.89c.283 1.035-.876 1.9-1.754 1.343l-3.441-2.558c-.532-.391-1.221-.347-1.67.141l-3.11 3.647c-.81.957-2.394.363-2.396-1.023v-3.723c0-.543-.217-1.063-.608-1.454l-3.125-3.267c-1.019-.868-.499-2.474.918-2.474h3.845c.736 0 1.4-.471 1.643-1.163l1.18-3.637z"/>
                        </svg>
                    </button>
                    <span>{{$post->likes}}</span>
                </form>
                @endif
            </div>
            <div>
                @if($saved == false)
                <form action="{{route("save.post", $post->id)}}" method="post">
                    @csrf
                    <button class="rounded-md border-2 border-solid border-red-500">
                        Save Post
                    </button>
                </form>
                @else
                <form action="{{route("save.remove", $post->id)}}" method="post">
                    @csrf
                    @method("delete")
                    <button class="rounded-md border-2 border-solid border-red-500">
                        Unsave Post
                    </button>
                </form>
                @endif
            </div>
            <div>
                <button id="writeComment" class="rounded-md border-2 border-solid border-red-500">
                    Add Comment
                </button>
                <button id="cancelComment" class="rounded-md border-2 border-solid border-red-500">
                    Cancel Comment
                </button>
            </div>
        </div>
        <hr>
        <div id="commentCreate" class="mt-6">
            <form action="{{route("comment.store", $post->id)}}" method="post">
                @csrf
                <div class="relative">
                    <input type="hidden" name="post_id" value={{$post->id}}>
                    <input type="text" name="comment" id="comment" value="{{old("comment")}}" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" required>
                    <label for="comment" class="text-sm absolute top-1/2 -translate-y-1/2 left-2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Enter your comment:</label>
                    @error("comment")
                        <x-errors>{{ $message }}</x-errors>
                    @enderror
                </div>
                <button class="rounded-md border-2 border-solid border-red-500">Post your comment</button>
            </form>
        </div>
        <div class="flex-items-center space-x-4 mb-6 relative" id="comments">
            <hr>
            @forelse($post->comments as $comment)
                <div class="flex flex-row">
                    <div>
                        <img src="/avatars/{{$comment->user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full ">
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{$comment->user->username}}</p>
                    </div>
                </div>
                <div class="flex flex-row">
                    <p class="text-lg text-gray-700 mb-6 break-words">
                        {{$comment->comment}}
                    </p>
                    @if($comment->user_id === Auth()->user()->id)
                        <form action="{{route("comment.delete", $comment->id)}}" method="post">
                            @csrf
                            @method("delete")
                            <button id="DeleteComment">
                                <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.06 2.93c.39-.39 1.02-.39 1.41 0l5.66 5.66c.39.39.39 1.02 0 1.41l-3.5 3.5c-.39.39-1.02.39-1.41 0l-5.66-5.66c-.39-.39-.39-1.02 0-1.41l3.5-3.5zM3 17.25V21h3.75l10.58-10.58-3.75-3.75L3 17.25z"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
                <hr>
            @empty
            <h2>No Comments on this post</h2>
            @endforelse
        </div>
    </div>
</x-app-layout>
