<?php
    use App\Models\User;
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
        </div>
    </div>
</x-app-layout>
