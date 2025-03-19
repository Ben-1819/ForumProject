<x-app-layout>
    @if(count($all_users) > 0)
    <div class="grid grid-cols-1 sm:grid-cold-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @foreach($all_users as $user)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
            <div class="p-4">
                <a href="{{route("user.show", $user->id)}}">
                    <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                    <div class="flex justify-between items-center mt-4">
                        <h2 class="font-semibold text-gray-800">{{$user->username}}</h2>
                    </div>
                </a>

                @hasrole("superadmin")
                    <form action="{{route("user.delete", $user->id)}}" method="post">
                        @csrf
                        @method("delete")
                        <x-my-button>
                            Delete User
                        </x-my-button>
                    </form>
                @endhasrole
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div>
        <h1 class="text-2xl flex-justify-center">NO USERS</h1>
    </div>
    @endif
</x-app-layout>
