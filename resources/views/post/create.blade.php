<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <div class="m-auto">
            <div class="mt-5 bg-white rounded-lg shadow">
                <div class="flex">
                    <div class="flex-1 py-5 pl-5 overflow-hidden">
                        <h1 class="inline text-2xl font-semibold leading-none">Create a new post</h1>
                    </div>
                </div>
                <form action="{{route("post.store")}}" method="post">
                    @csrf
                    <div class="px-5 pb-5">
                        <div class="flex">
                            <div class="flex-grow">
                                <div class="flex items-center justify-center">
                                    <div class="relative">
                                        <input type="text" name="title" id="title" value="{{old("title")}}" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" required>
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
                                        <textarea name="description" id="description" value="{{old("description")}}" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" required></textarea>
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
                                    <x-my-button>Create Post</x-my-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
