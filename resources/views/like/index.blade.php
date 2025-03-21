@php
    use App\Models\Like;
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
@endphp
<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <a href="{{route("post.show", $post->id)}}">
            <x-my-button>Back</x-my-button>
        </a>
        <!-- Post Header -->
        <div class="flex items-center space-x-4 mb-6">
            <!-- Profile Picture -->
            <a href="{{route("user.show", $post->user_id)}}" class="flex flex-row">
                <img src="/avatars/{{$post->user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full">

            <!-- User Info -->
            <div>
                <p class="font-semibold text-gray-800">{{$post->user->username}}</p>
            </div>
            </a>
            @if(session("LikeMessage"))
                <x-errors>{{session("LikeMessage")}}</x-errors>
            @endif
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
        </div>
        <hr>
        <div class="flex-items-center space-x-4 mb-6 relative" id="comments">
            <hr>
            @forelse($post->post_likes as $like)
                <div class="flex flex-row">
                    <a href="{{route("user.show", $like->user->id)}}" class="flex flex-row">
                        <div>
                            <img src="/avatars/{{$like->user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full ">
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{$like->user->username}}</p>
                        </div>
                    </a>
                </div>
                <div class="flex items-left justify-between text-sm text-gray-500">
                    Liked at: {{$like->created_at}}
                </div>
                <hr>
            @empty
            <h2>No likes on this post</h2>
            @endforelse
        </div>
    </div>
</x-app-layout>
