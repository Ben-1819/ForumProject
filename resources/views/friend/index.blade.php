@php
    use App\Models\User;
@endphp

<x-app-layout>
    @if(count($all_friends) > 0)
    <div class="grid grid-cols-1 sm:grid-cold-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @foreach($all_friends as $friend)
        @php
            if($friend->user1_id === request()->user()->id){
                $user = User::find($friend->user2_id);
            }
            else{
                $user = User::find($friend->user1_id);
            }
        @endphp
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
            <div class="p-4">
                <a href="{{route("user.show", $user->id)}}">
                    <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                    <div class="flex justify-between items-center mt-4">
                        <h2 class="font-semibold text-gray-800">{{$user->username}}</h2>
                    </div>
                </a>
                @if($friend->favourite == false)
                <form action="{{route("friend.addFavourite", $friend->id)}}" method="post">
                    @csrf
                    @method("patch")
                    <x-my-button>Favourite Friend</x-my-button>
                </form>
                @else
                <form action="{{route("friend.removeFavourite", $friend->id)}}" method="post">
                    @csrf
                    @method("patch")
                    <x-my-button>Remove Favourite</x-my-button>
                </form>
                @endif
                <form action="{{route("friend.remove", $friend->id)}}" method="post">
                    @csrf
                    @method("delete")
                    <x-my-button>Remove Friend</x-my-button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div>
        <h1 class="text-2xl flex-justify-center">You have no friends</h1>
    </div>
    @endif
</x-app-layout>
