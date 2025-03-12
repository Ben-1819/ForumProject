<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            "title" => ["required", "string", "max:100"],
            "description" => ["required", "string", "max:1000"],
        ];
    }

    public function messages():array
    {
        // Create custom error messages
        $messages = [
            "title.required" => "Title is a required field",
            "title.string" => "Title must be of the data type string",
            "title.max" => "Title must be 100 characters or less",
            "description.required" => "Description is a required field",
            "description.string" => "Description must be of the data type string",
            "description.max" => "Description must not exceed 1000 characters",
        ];

        // Return error messages
        return $messages;
    }
}
