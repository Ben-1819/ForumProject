<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <a href="{{route("user.index")}}">
            <button class="rounded-md border-2 border-solid border-red-500">
                All Users
            </button>
        </a>
        <a href="{{route("friend.requests")}}">
            <button class="rounded-md border-2 border-solid border-red-500">
                Your Friend Requests
            </button>
        </a>
        <a href="{{route("friend.index")}}">
            <button class="rounded-md border-2 border-solid border-red-500">
                Your Friends
            </button>
        </a>
        <a href="{{route("friend.favourites")}}">
            <button class="rounded-md border-2 border-solid border-red-500">
                Your Favourite Friends
            </button>
        </a>
        <a href="{{route("post.create")}}">
            <button class="rounded-md border-2 border-solid border-red-500">
                Create A Post
            </button>
        </a>
        <a href="{{route("user.chats")}}">
            <button class="rounded-md border-2 border-solid border-red-500">
                Message Other Users
            </button>
        </a>
    </div>
</x-app-layout>
