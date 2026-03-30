<?php

namespace App\Http\Requests\Blog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            
            'title' => 'required|min:3|max:50',
            'category' => 'required',
            'content' => 'required|min:5|max:6000',
            'image' => [
                'mimes:jpeg,png,jpg',
                'max:5120',
                'min:128',
                'dimensions:min_width=400,min_height=400'
            ]
        ];
    }

    public function messages(): array
    {
        return [

            // title
            'title.required' => 'title is required',
            'title.min' => 'atleast 3 character required',
            'title.max' => 'title not more than 50 character',

            // category
            'category.required' => 'category is required',

            // content
            'content.required' => 'content is required',
            'content.min:5' => 'atleast 5 character required',
            'content.max' => 'title not more than 6000 character',

            // image
            'image.mimes' => 'only .jpeg, .png, .jpg format are allow be',
            'image.max' => 'max 2 mb size are allow',
            'image.min' => 'image size alteast 128 kb',
            'image.min_width' => 'image must be more than 400 px width',
            'image.min_height' => 'image must be more than 400 px height'
        ];
    }
}
