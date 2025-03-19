<x-app-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @forelse($users_likes as $like)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
            <div class="p-4">
                <a href="{{route("user.show", $like->user->id)}}">
                    <img src="/avatars/{{$like->user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                    <p class="font-semibold">{{$like->user->username}}</p>
                </a>
                <h3 class="text-xl font-semibold">{{$like->post->title}}</h3>
                <a href="{{route('post.show', $like->post->id)}}">
                    <button class="rounded-md border-2 border-solid border-red-500">
                        View Post
                    </button>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div>
        <h1 class="text-2xl flex-justify-center">You have not liked any posts</h1>
    </div>
    @endforelse
</x-app-layout>
