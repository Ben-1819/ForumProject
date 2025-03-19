<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Your Archived chats
        </h2>
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
