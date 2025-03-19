<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostReplyRequest extends FormRequest
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
        // Define Validation Rules
        return [
            "contents" => ["required", "string", "max:100"]
        ];
    }

    public function messages():array
    {
        // Create custom error messages
        $messages = [
            "contents.required" => "Reply is a required field",
            "contents.string" => "Reply must be of the data type string",
            "contents.max" => "Reply must not be more than 100 characters long",
        ];

        // Return custom error messages
        return $messages;
    }
}
