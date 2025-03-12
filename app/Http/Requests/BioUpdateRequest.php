<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class BioUpdateRequest extends FormRequest
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
        // Create validation rules
        return [
            "bio" => ["required", "string", "max:500"],
        ];
    }

    public function messages(): array
    {
        // Create custom error messages
        $messages = [
            "bio.required" => "Bio is a required field",
            "bio.string" => "Data entered in your bio must be of data type string",
            "bio.max" => "Your bio cannot be longer than 500 characters",
        ];

        // Return the custom error messages
        return $messages;
    }
}
