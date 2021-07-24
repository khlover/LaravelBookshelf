<?php

namespace App\Http\Requests;

use App\Rules\DuplicateBook;
use Illuminate\Foundation\Http\FormRequest;

class BookSearchTitle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
        ];
    }

    /**
     * Custom error messages for failing validation
     *
     * @return void
     */
    public function messages()
    {
        return [
            'title.required' => 'Please enter a title',
        ];
    }
}
