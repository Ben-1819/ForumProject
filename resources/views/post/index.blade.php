@php
    use App\Models\User;
    use App\Models\Friend;
@endphp
<x-app-layout>
    @if(count($all_posts) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @foreach($all_posts as $post)
        @php
            $user = User::find($post->user_id);
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
        @endphp
        @if($user->public == true || $friends == true || Auth::user()->id == $user->id)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
            <div class="p-4">
                <a href="{{route("user.show", $user->id)}}">
                    <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                    <p class="font-semibold">{{$user->username}}</p>
                </a>
                <h3 class="text-xl font-semibold">{{$post->title}}</h3>
                <a href="{{route('post.show', $post->id)}}">
                    <x-my-button>
                        View Post
                    </x-my-button>
                </a>
            </div>
        </div>
        @else
        @continue
        @endif
        @endforeach
    </div>
    @else
    <div>
        <h1 class="text-2xl flex-justify-center">NO USERS</h1>
    </div>
    @endif
</x-app-layout>
