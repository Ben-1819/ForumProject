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
            <div class="flex items-center space-x-2">
                <span>Total Saves: {{count($post->saves)}}</span>
            </div>
        </div>
        <hr>
        <div class="flex-items-center space-x-4 mb-6 relative" id="comments">
            <hr>
            @forelse($post->saves as $save)
                <div class="flex flex-row">
                    <a href="{{route("user.show", $save->user->id)}}" class="flex flex-row">
                        <div>
                            <img src="/avatars/{{$save->user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full ">
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{$save->user->username}}</p>
                        </div>
                    </a>
                </div>
                <div class="flex items-left justify-between text-sm text-gray-500">
                    Saved at: {{$save->created_at}}
                </div>
                <hr>
            @empty
            <h2>Nobody has saved this post</h2>
            @endforelse
        </div>
    </div>
</x-app-layout>
