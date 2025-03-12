@php
    use App\Models\User;
    $user = User::find($post->user_id);
@endphp
<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Post Header -->
        <div class="flex items-center space-x-4 mb-6">
            <!-- Profile Picture -->
            <img src="/avatars/{{$user->avatar}}" alt="User profile" class="w-12 h-12 rounded-full">

            <!-- User Info -->
            <div>
                <p class="font-semibold text-gray-800">{{$user->username}}</p>
            </div>
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

            <!-- Likes -->
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 3.498c.3-1.057 1.804-1.057 2.105 0l1.173 3.727c.196.634.757 1.035 1.411 1.035h3.897c1.076 0 1.52 1.372.728 2.054l-3.15 2.43c-.415.318-.588.87-.459 1.41l1.07 3.89c.283 1.035-.876 1.9-1.754 1.343l-3.441-2.558c-.532-.391-1.221-.347-1.67.141l-3.11 3.647c-.81.957-2.394.363-2.396-1.023v-3.723c0-.543-.217-1.063-.608-1.454l-3.125-3.267c-1.019-.868-.499-2.474.918-2.474h3.845c.736 0 1.4-.471 1.643-1.163l1.18-3.637z"/>
                </svg>
                <span>{{$post->likes}}</span>
            </div>
        </div>
    </div>
</x-app-layout>
