<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePictureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        log::info("Check if the current user is the owner of the account");
        if(request()->user()->id == $request->user_id){
            log::info("The current user is the owner of the account");
            return true;
        }
        else{
            log::info("The current user is not the owner of the account");
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define validation rules
        return [
            "avatar" => ["required", "image"],
        ];
    }

    public function messages():array
    {
        // Create custom error messages
        $messages = [
            "avatar.required" => "A profile picture is required",
            "avatar.image" => "Profile pictures must be an image",
        ];

        // Return custom error messages
        return $messages;
    }
}
