<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <a href="{{route("post.show", $comment->post->id)}}">
            <x-my-button>Back</x-my-button>
        </a>
        <!-- Post Header -->
        <div class="flex items-center space-x-4 mb-6">
            <a href="{{route("user.show", $comment->user->id)}}" class="flex flex-row">
                <!-- Profile Picture -->
                <img src="/avatars/{{$comment->user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full">

                <!-- User Info -->
                <div>
                    <p class="font-semibold text-gray-800">{{$comment->user->username}}</p>
                </div>
            </a>
            @if(session("ReplyMessage"))
                <x-errors>{{session("ReplyMessage")}}</x-errors>
            @endif
        </div>

        <!-- Post Content -->
        <p class="text-lg text-gray-700 mb-6 break-words">
            {{$comment->comment}}
        </p>

        <!-- Post Footer -->
        <div class="flex items-center justify-between text-sm text-gray-500">
            <p>{{$comment->created_at}}</p>

            <div>
                <button id="writeComment" class="rounded-md border-2 border-solid border-red-500">
                    Add Reply
                </button>
                <button id="cancelComment" class="rounded-md border-2 border-solid border-red-500">
                    Cancel Reply
                </button>
            </div>
        </div>
        <hr>
        <div id="commentCreate" class="mt-6">
            <form action="{{route("reply.store", $comment->id)}}" method="post">
                @csrf
                <div class="relative">
                    <input type="hidden" name="comment_id" value={{$comment->id}}>
                    <input type="text" name="contents" id="contents" value="{{old("contents")}}" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" required>
                    <label for="contents" class="text-sm absolute top-1/2 -translate-y-1/2 left-2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Enter your reply:</label>
                    @error("reply")
                        <x-errors>{{ $message }}</x-errors>
                    @enderror
                </div>
                <x-my-button>Post your reply</x-my-button>
            </form>
        </div>
        <div class="flex-items-center space-x-4 mb-6 relative" id="comments">
            <hr>
            @forelse($comment->replies as $reply)
                <div class="flex flex-row">
                    <a href="{{route("user.show", $reply->user->id)}}" class="flex flex-row">
                        <img src="/avatars/{{$reply->user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full ">
                        <div>
                            <p class="font-semibold text-gray-800">{{$reply->user->username}}</p>
                        </div>
                    </a>
                </div>
                <div class="flex flex-row">
                    <p class="text-lg text-gray-700 mb-6 break-words">
                        {{$reply->contents}}
                    </p>
                    @if($reply->user_id === Auth()->user()->id)
                        <form action="{{route("reply.delete", $reply->id)}}" method="post">
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
                <div class="flex items-left justify-between text-sm text-gray-500">
                    {{$reply->created_at}}
                </div>
                <hr>
            @empty
            <h2>No Replies On This Comment</h2>
            @endforelse
        </div>
    </div>
</x-app-layout>
