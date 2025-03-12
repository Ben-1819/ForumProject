@if(auth()->check())
<a href="{{route("profile.show")}}">
    <img src="/avatars/{{ Auth::user()->avatar }}" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
</a>
@else
<a href="{{route("register")}}">
    <img src="/avatars/userIcon.png" class="h-20 w-20 rounded-full object-scale-down object-[59%_-4px]">
</a>
@endif
