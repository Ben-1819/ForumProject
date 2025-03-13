<?php
    use App\Models\Friend;
    use App\Models\Post;
    use Spatie\Permission\Models\Role;
    $users_posts = Post::where("user_id", $user->id)->get();
    $users_friends = Friend::where("user1_id", $user->id)->orWhere("user2_id", $user->id)
        ->where("status", "accepted")
        ->get();
    if(count($users_friends) > 0){
        foreach($users_friends as $friend){
            if(request()->user()->id == $friend->user1_id && $friend->status == "accepted"){
                $friend = Friend::find($friend->id);
                $friends = true;
                break;
            }
            elseif(request()->user()->id == $friend->user2_id && $friend->status == "accepted"){
                $friend = Friend::find($friend->id);
                $friends = true;
                break;
            }
            else{
                $friends = false;
            }
        }
    }
    else{
        $friends = false;
    }
?>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __($user->username)}}
        </h2>
        @if(session("message"))
        <h3 class="font semibold">{{session("message")}}</h3>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex justify-center">
                        <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                    </div>
                    @if($user->public == true || $friends == true || request()->user()->id == $user->id)
                    <label>First name: {{$user->first_name}}</label>
                    <br>
                    <label>Last Name: {{$user->last_name}}</label>
                    <br>
                    <label>Created on: {{$user->created_at}}</label>
                    <br>
                    <label>Bio:</label>
                    <textarea readonly>{{$user->bio}}</textarea>
                        @if($friends == true && request()->user()->id != $user->id)
                        <form action="{{route("friend.remove", $friend->id)}}" method="post">
                            @csrf
                            @method("delete")
                            <button class="rounded-md border-2 border-solid border-red-500">Remove Friend</button>
                        </form>
                        @elseif($friends == false && request()->user()->id != $user->id)
                        <form action="{{route("friend.request", $user->id)}}" method="post">
                            @csrf
                            <button class="rounded-md border-2 border-solid border-red-500">Send Friend Request</button>
                        @endif
                    @else
                    <p>This account is not public</p>
                    <form action="{{route("friend.request", $user->id)}}" method="post">
                        @csrf
                        <button class="rounded-md border-2 border-solid border-red-500">Send Friend Request</button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="max-w-xl">
                @if($user->public == true || $friends == true || request()->user()->id == $user->id)
                    @if(count($users_posts) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
                        @foreach($users_posts as $post)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
                            <div class="p-4">
                                <a href="{{route("user.show", $user->id)}}">
                                    <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                                    <p class="font-semibold">{{$user->username}}</p>
                                </a>
                                <h3 class="text-xl font-semibold">{{$post->title}}</h3>
                                <a href="{{route('post.show', $post->id)}}">
                                    <button class="rounded-md border-2 border-solid border-red-500">
                                        View Post
                                    </button>
                                </a>
                                <a href="{{route("post.edit", $post->id)}}">
                                    <button class="rounded-md border-2 border-solid border-red-500">
                                        Edit Post
                                    </button>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div>
                        <h1 class="text-xl font-bold">{{$user->username}} has not posted anything yet</h1>
                    </div>
                    @endif
                @else
                <div>
                    <h1 class="text-xl font-bold">Add {{$user->username}} as a friend to see what they are posting!</h1>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
