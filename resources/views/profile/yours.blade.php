<?php
    use Spatie\Permission\Models\Role;
?>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __("Profile")}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <label>First name: {{$user->first_name}}</label>
                    <br>
                    <label>Last Name: {{$user->last_name}}</label>
                    <br>
                    <label>Email address: {{$user->email}}</label>
                    <br>
                    <label>Bio:</label>
                    <textarea readonly>{{$user->bio}}</textarea>
                    <br>
                    <a href="{{route("profile.editBio")}}" class="border-2 border-solid border-red-500">
                        Update your bio
                    </a>
                    <br>
                    <a href="{{route("profile.editPicture")}}" class="border-2 border-solid border-red-500">
                        Update your picture
                    </a>
                </div>
                <form action="{{route("profile.edit")}}" method="get">
                    @csrf
                    <button class="border-2 border-solid border-red-500 hover:bg-black hover:text-white flex flex-1 justify-center float-left">Edit Profile</button>
                </form>
            </div>
            <div class="max-w-xl">
                @forelse ($user->posts as $post)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
                            <div class="p-4">
                                <a href="{{route("user.show", $user->id)}}">
                                    <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                                    <p class="font-semibold">{{$user->username}}</p>
                                </a>
                                <h3 class="text-xl font-semibold">{{$post->title}}</h3>
                                <div class="flex flex-row">
                                    <a href="{{route('post.show', $post->id)}}">
                                        <x-my-button>
                                            View Post
                                        </x-my-button>
                                    </a>
                                    <a href="{{route("post.edit", $post->id)}}">
                                        <x-my-button>
                                            Edit Post
                                        </x-my-button>
                                    </a>
                                </div>
                                <div class="flex flex-row">
                                    <form action="{{route("post.destroy", $post->id)}}" method="post">
                                        @csrf
                                        @method("delete")
                                        <x-my-button>
                                            Delete Post
                                        </x-my-button>
                                    </form>
                                    <a href="{{route("post.whoSaved", $post->id)}}">
                                        <x-my-button>
                                            View Saved
                                        </x-my-button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div>
                        <h1 class="text-xl font-bold">You have no posts</h1>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
