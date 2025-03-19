@php
    use App\Models\Friend;
@endphp
<x-app-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @forelse($all_posts as $post)
            @php
                $users_friends = Friend::where("user1_id", $post->user->id)->orWhere("user2_id", $post->user->id)
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
            @if($post->user->public == true || $friends == true || Auth::user()->id == $post->user->id)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
                    <div class="p-4">
                        <a href="{{route("user.show", $post->user->id)}}">
                            <img src="/avatars/{{$post->user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                            <p class="font-semibold">{{$post->user->username}}</p>
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
    </div>
        @empty
            <div>
                <h1 class="text-2xl flex-justify-center">No Posts</h1>
            </div>
        @endforelse
</x-app-layout>
