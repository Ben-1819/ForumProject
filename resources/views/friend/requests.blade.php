@php
    use App\Models\User;
@endphp

<x-app-layout>
    @if(count($all_requests) > 0)
    <div class="grid grid-cols-1 sm:grid-cold-2 md:grid-cols-3 lg:grid-cols-4 gap-6 place-items-center">
        @foreach($all_requests as $request)
        @php
            $user = User::find($request->user1_id);
        @endphp
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border-2 border-solid border-red-500">
            <div class="p-4">
                <a href="{{route("user.show", $user->id)}}">
                    <img src="/avatars/{{$user->avatar}}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
                    <div class="flex justify-between items-center mt-4">
                        <h2 class="font-semibold text-gray-800">{{$user->username}}</h2>
                    </div>
                </a>
                <form action="{{route("friend.accept", $request->id)}}" method="post">
                    @csrf
                    @method("patch")
                    <button class="rounded-md border-2 border-solid border-red-500">Accept Request</button>
                </form>
                <form action="{{route("friend.reject", $request->id)}}" method="post">
                    @csrf
                    @method("delete")
                    <button class="rounded-md border-2 border-solid border-red-500">Reject Request</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div>
        <h1 class="text-2xl flex-justify-center">You have no friend requests</h1>
    </div>
    @endif
</x-app-layout>
