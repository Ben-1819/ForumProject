<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        if(request()->user()->id == $request->user_id){
            log::info("Current user is the user who created the post");
            return true;
        }
        else{
            log::info("Current user is not the user who created the post");
            abort(403, "Not authorised to edit this post");
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Define the validation rules
        return [
            "title" => ["required", "string", "max:100"],
            "description" => ["required", "string", "max:1000"],
        ];
    }

    public function messages():array
    {
        // Create custom error messages
        $messages = [
            "title.required" => "Title is a required field",
            "title.string" => "Title must be of data type string",
            "title.max" => "Title must not exceed 100 characters",
            "description.required" => "Description is a required field",
            "description.string" => "Description must be of the data type string",
            "description.max" => "Description must not exceed 1000 characters",
        ];

        // Return custom error messages
        return $messages;
    }
}
