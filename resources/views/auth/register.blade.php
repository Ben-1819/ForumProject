<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="relative mt-5">
            <input id="username" class="w-full h-10 px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" type="text" name="username" :value="old("username")" required autocomplete="username"/>
            <label for="username" class="text-sm absolute top-1/2 -translate-y-1/2 left-2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Username</label>
            <x-input-error :messages="$errors->get("email")" class="mt-2" />
        </div>

        <!-- Bio -->
        <div class="relative mt-5">
            <textarea id="bio" class="w-full px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer" type="text" name="bio" :value="old("bio")" required autocomplete="bio"></textarea>
            <label for="bio" class="text-sm absolute top-1/2 -translate-y-1/2 left-2 peer-focus:top-0 bg-white z-20 transition-all duration-300">Bio</label>
            <x-input-error :messages="$errors->get("bio")" class="mt-2" />
        </div>

        <!-- Public Account -->
        <div class="mt-4">
            <x-input-label for="public">Private account:</x-input-label>
            <input type="checkbox" id="public" name="public" class="rounded-md accent-red-900 border-2 border-solid border-red-300 focus:ring-red-500":value="old("public")">
        </div>

        <!-- Profile Picture -->
        <div class="mt-4">
            <x-input-label for="avatar">Profile Picture:</x-input-label>
            <input type="file" id="avatar" name="avatar" class="px-2 rounded-md border border-red-300 hover:border-red-500 focus:border-red-500 focus:ring-red-500 peer">
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
