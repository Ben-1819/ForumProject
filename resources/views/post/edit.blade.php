<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <div class="m-auto">
            <div class="mt-5 bg-white rounded-lg shadow">
                <div class="flex">
                    <div class="flex-1 py-5 pl-5 overflow-hidden">
                        <h1 class="inline text-2xl font-semibold leading-none">Update post {{$post->title}}</h1>
                    </div>
                </div>
                <form action="{{route("post.update", $post)}}" method="post">
                    @csrf
                    @method("put")
                    <div>
                        <input type="hidden" id="post_id" name="post_id" value={{$post->id}}>
                        <input type="hidden" id="user_id" name="user_id" value={{$post->user_id}}>
                        <input type="hidden" id="likes" name="likes" value={{$post->likes}}>
                        <input type="hidden" id="created_at" name="created_at" value={{$post->created_at}}>
                    </div>
                    <div class="px-5 pb-5">
                        <div class="flex">
                            <div class="flex-grow">
                                <div class="flex items-center justify-center">
                                    <div class="relative">
                                        <input type="text" name="title" id="title" value={{$post->title}} placeholder="{{$post->title}}" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" required>
                                        <label for="title" class="text-sm absolute top-1/2 -translate-y-1/2 left-2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Post Title:</label>
                                        @error("title")
                                            <x-errors>{{ $message }}</x-errors>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3 mb-3">
                    <div class="px-5 pb-5">
                        <div class="flex">
                            <div class="flex-grow">
                                <div class="flex items-center justify-center">
                                    <div class="relative">
                                        <textarea name="description" id="description" value={{$post->description}} placeholder="{{$post->description}}" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" required></textarea>
                                        <label for="description" class="text-sm absolute top-1/2 -translate-y-1/2 left-2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Post Contents: </label>
                                        @error("description")
                                            <x-errors>{{ $message }}</x-errors>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3 mb-3">
                    <div class="px-5 pb-5">
                        <div class="flex">
                            <div class="flex-grow">
                                <div class="pt-5 flex items-center justify-center">
                                    <button class="border-2 border-solid border-red-500">Create Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
