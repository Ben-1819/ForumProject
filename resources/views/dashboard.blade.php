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
            <x-my-button>
                All Users
            </x-my-button>
        </a>
        <a href="{{route("friend.requests")}}">
            <x-my-button>
                Your Friend Requests
            </x-my-button>
        </a>
        <a href="{{route("friend.index")}}">
            <x-my-button>
                Your Friends
            </x-my-button>
        </a>
        <a href="{{route("friend.favourites")}}">
            <x-my-button>
                Your Favourite Friends
            </x-my-button>
        </a>
        <a href="{{route("post.create")}}">
            <x-my-button>
                Create A Post
            </x-my-button>
        </a>
        <a href="{{route("chats")}}">
            <x-my-button>
                Message Other Users
            </x-my-button>
        </a>
    </div>

    <div>
        <a href="{{route("post.index")}}">
            <x-my-button>
                All posts
            </x-my-button>
        </a>
    </div>
</x-app-layout>
