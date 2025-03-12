<?php
    use App\Models\User;
    use Spatie\Permission\Models\Role;
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
                    <label>First name: {{$user->first_name}}</label>
                    <br>
                    <label>Last Name: {{$user->last_name}}</label>
                    <br>
                    <label>Email address: {{$user->email}}</label>
                    <br>
                    <label>Bio:</label>
                    <textarea readonly>{{$user->bio}}</textarea>
                    <form action="{{route("friend.request", $user->id)}}" method="post">
                        @csrf
                        <button class="rounded-md border-2 border-solid border-red-500">Send Friend Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
