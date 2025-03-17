<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            "comment" => ["required", "string", "max:100"],
        ];
    }

    public function messages(): array
    {
        // Create custom error messages
        $messages = [
            "comment.required" => "You cannot post an empty comment",
            "comment.string" => "Comment must be of the data type string",
            "comment.max" => "Comments cannot be longer than 100 characters",
        ];

        // Return the custom error messages
        return $messages;
    }
}
