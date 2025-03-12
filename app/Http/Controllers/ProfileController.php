<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Http\Requests\BioUpdateRequest;
use App\Http\Requests\UpdateProfilePictureRequest;
use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function show(Request $request){
        return view("profile.show", [
            "user" => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function editBio(Request $request){
        log::info("Showing bio update review");
        return view("profile.bio-update", [
            "user" => $request->user(),
        ]);
    }

    public function updateBio(BioUpdateRequest $request, User $user){
        log::info("Validate the input and update the record in the users table");
        $update_Bio = User::where("id", $request->user_id)->update($request->validated());
        log::info("Bio has been updated");
        log::info("New Bio: {bio}", ["bio" => $request->bio]);

        log::info("Returning to profile.show view");
        return redirect()->route("profile.show");
    }

    public function editPicture(Request $request){
        log::info("Show the profile picture update view");
        return view("profile.picture-update", [
            "user" => $request->user(),
        ]);
    }

    public function updatePicture(UpdateProfilePictureRequest $request){
        log::info("Validate that the users new profile picture is a file");
        $request->validated();
        $avatarName = time(). '.' . $request->avatar->getClientOriginalExtension();
        log::info("Users new avatar: {avatarName}", ["avatarName" => $avatarName]);
        $request->avatar->move(public_path("avatars"), $avatarName);
        $update_avatar = User::where("id", $request->user_id)->update([
            "avatar" => $avatarName,
        ]);
        log::info("Deleting users old profile picture");
        File::delete(public_path("avatars/". request()->user()->avatar));

        return redirect()->route("profile.show");
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
