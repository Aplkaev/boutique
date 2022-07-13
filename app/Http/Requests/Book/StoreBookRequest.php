<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->hasUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'cover' => 'nullable|image:jpeg,png,jpg,gif,webp|max:2048',
            'author_id' => 'required|integer|exists:authors,id',
            'publish_year' => 'required|integer|min:1800|max:' . date('Y'),
        ];
    }
}
