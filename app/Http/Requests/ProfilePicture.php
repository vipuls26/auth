<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfilePicture extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profilePhoto' => 'required|mimes::jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'profile photo are required',
            'mimes' => 'only .jpeg, .png, .jpg format are allow',
            'max' => 'max 2 mb size are allow'
        ];
    }
}
