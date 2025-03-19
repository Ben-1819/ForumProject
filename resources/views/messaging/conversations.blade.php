<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Conversations
            </h2>
            <x-my-button>
                <a href="{{route("archived.index")}}">
                    View archived chats
                </a>
            </x-my-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto p-8">
                    <h1 class="text-2xl font-bold mb-4">List of conversations</h1>
                    <div class="overflow-x-auto">
                        @if (count($chats) > 0)
                        <table class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-grey-100">
                                    <th class="border border-grey-300 px-4 py-2 text-left w-12">#</th>
                                    <th class="border border-grey-300 px-4 py-2 text-left ">Name</th>
                                    <th class="border border-grey-300 px-4 py-2 text-left w-32">Open</th>
                                    <th class="border border-grey-300 px-4 py-2 text-left w-32">Archive</th>
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
                                            <a navigate href="{{route("chat", $otherUser->id)}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6 me-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                                </svg>

                                                {{-- Display unread message count --}}
                                                <span id="unread-count-{{ $otherUser->id }}"
                                                    class="{{ $otherUser->unread_messages_count > 0 ? 'absolute top-0 right-11 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full' : '' }}">
                                                    {{ $otherUser->unread_messages_count > 0 ? $otherUser->unread_messages_count : null }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 relative">
                                            <form action="{{route("archive", $otherUser->id)}}" method="post">
                                                @csrf
                                                @method("delete")
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="60" height="60">
                                                        <!-- Folder Icon -->
                                                        <rect x="10" y="20" width="80" height="60" rx="8" ry="8" fill="#FFCC00" stroke="#FFA500" stroke-width="2"/>
                                                        <polygon points="10,20 30,20 25,10 35,10 40,20 70,20 65,10 75,10 80,20" fill="#FF9900"/>
                                                        <!-- Chat Bubble -->
                                                        <ellipse cx="50" cy="50" rx="25" ry="12" fill="#FFFFFF" stroke="#000000" stroke-width="2"/>
                                                        <text x="50" y="55" font-size="10" text-anchor="middle" fill="#000000">Chat</text>
                                                        <!-- Downward Arrow -->
                                                        <polygon points="50,70 45,80 55,80" fill="#000000"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h1 class="font-semibold text-2xl">No conversations</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="module">
    window.Echo.private("unread-channel.{{ Auth::user()->id }}")
        .listen("UnreadMessage", (event) => {
            const unreadCountElement = document.getElementById(`unread-count-${event.senderId}`);
            if (unreadCountElement){
                event.unreadCount == 0 ? unreadCountElement.classList = '' : unreadCountElement.classList =
                    'absolute top-0 right-11 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full';
                unreadCountElement.textContent = event.unreadCount > 0 ? event.unreadCount : '';
            }
        });
</script>
