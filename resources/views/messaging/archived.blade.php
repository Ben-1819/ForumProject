<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Your Archived chats
        </h2>
        @if(session("message"))
            <x-errors>
                {{session("message")}}
            </x-errors>
        @endif
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto p-8">
                    <h1 class="text-2xl font-bold mb-4">List Of Archived Conversations</h1>
                    <div class="overflow-x-auto">
                        @if (count($chats) > 0)
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-grey-100">
                                    <th class="border border-grey-300 px-4 py-2 text-left w-12">#</th>
                                    <th class="border border-grey-300 px-4 py-2 text-left ">Name</th>
                                    <th class="border border-grey-300 px-4 py-2 text-left w-32">Restore</th>
                                    <th class="border border-grey-300 px-4 py-2 text-left w-32">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chats as $chat)
                                    @php
                                        $otherUser = $chat->sender_id == Auth::id() ? $chat->receiver : $chat->sender;
                                    @endphp
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{$loop->index + 1}}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{$otherUser->username}}</td>
                                        <td class="border border-gray-300 px-4 py-2 relative">
                                            <form action="{{route("restoreArchived", $otherUser->id)}}" method="post">
                                                @csrf
                                                @method("patch")
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="60" height="60">
                                                        <!-- Folder Icon -->
                                                        <rect x="10" y="20" width="80" height="60" rx="8" ry="8" fill="#FFCC00" stroke="#FFA500" stroke-width="2"/>
                                                        <polygon points="10,20 30,20 25,10 35,10 40,20 70,20 65,10 75,10 80,20" fill="#FF9900"/>
                                                        <!-- Chat Bubble -->
                                                        <ellipse cx="50" cy="50" rx="25" ry="12" fill="#FFFFFF" stroke="#000000" stroke-width="2"/>
                                                        <text x="50" y="55" font-size="10" text-anchor="middle" fill="#000000">Chat</text>
                                                        <!-- Upward Arrow (Restore) -->
                                                        <polygon points="50,30 45,20 55,20" fill="#000000"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 relative">

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h1 class="font-semibold text-2xl">No Archived Conversations</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
