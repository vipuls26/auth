<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'required|string|max:15|min:2',
            'email' => 'required|string|lowercase|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
            'password_confirmation' => 'required|same:password',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.min' => 'atleast 2 character',
            'name.max' => 'not more than 15 character',

            'email.required' => 'email is required',
            'email.email' => 'valid email format.',
            'email.unique' => 'this email already exist BE',
            'email.lowercase' => 'email must be in lower case',

            'password.required' => 'password is required',
            'password.min' => 'atleast 8 character',

            'password_confirmation.required' => 'confirm password is required',
            'password_confirmation.same' => 'confirm password not match',

        ];
    }
}
