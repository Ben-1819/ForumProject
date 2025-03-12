<x-app-layout>
    <div class="flex h-screen bg-grey-100">
        <div class="m-auto">
            <div class="mt-5 bg-white rounded-lg shadow">
                <div class="flex">
                    <div class="flex-1 py-5 pl-5 overflow-hidden">
                        <h1 class="inline text-2xl font-semibold leading-none">Update your picture:</h1>
                    </div>
                </div>
                <form action="{{route("profile.updatePicture")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <div>
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                    </div>

                    <div class="px-5 pb-5">
                        <div class="flex">
                            <div class="flex-grow">
                                <div class="flex items-center justify-center">
                                    <input name="avatar" id="avatar" type="file" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500"></input>
                                    @error("avatar")
                                        <x-errors>{{$message}}</x-errors>
                                    @enderror
                                    <label for="avatar" class="text-sm absolute top-1/2 -translate-y-1/2 left:2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Picture</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <div class="flex">
                            <div class="flex-grow">
                                <div class="pt-5 flex items-center justify-center">
                                    <button class="border-2 border-solid border-red-500">Update your picture</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
