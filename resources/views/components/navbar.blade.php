@vite(['resources/css/app.css', 'resources/js/app.js'])
<div class="bg-red-700 border-black border-b-2">
    <a class="text-white text-xl flex flex-1" href="{{route('welcome')}}">Home</a>
    {{$slot}}
</div>
