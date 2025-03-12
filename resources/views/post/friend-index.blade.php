@php
    use App\Models\User;
    use App\Models\Friend;
@endphp
<x-app-layout>
    @if(count($friends_posts) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @foreach($friends_posts as $post)
        @php
            $user = User::find($post->user_id);
        @endphp
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
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div>
        <h1 class="text-2xl flex-justify-center">Your friends have not posted anything</h1>
    </div>
    @endif
</x-app-layout>
