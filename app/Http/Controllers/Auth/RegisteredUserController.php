<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            "last_name" => ["required", "string", "max:255"],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "username" => ["required", "string", "max:50", "unique:".User::class],
            "avatar" => ["required", "image"],
            "bio" => ["required", "string", "max:500"],

        ]);

        $avatarName = time(). '.' .$request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path("avatars"), $avatarName);

        $user = User::create([
            'first_name' => $request->first_name,
            "last_name" => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "username" => $request->username,
            "avatar" => $avatarName,
            "bio" => $request->bio,
            "public" => $request->public == "on" ? 1:0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
