<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'title' => 'required|max:120|unique:posts,title,' . $this->post->id,
            'content' => 'required|string|min:56',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The name field must not be greater than :max characters.',
            'content.required' => 'The content field is required.',
            'content.min' => 'The content field must not be smaller than :min characters.',
        ];
    }
}
