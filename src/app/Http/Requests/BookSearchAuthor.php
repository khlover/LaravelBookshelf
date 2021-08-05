<?php

namespace App\Http\Requests;

use App\Rules\DuplicateBook;
use Illuminate\Foundation\Http\FormRequest;

class BookSearchAuthor extends FormRequest
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
            "author" => ["required"],
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
            "author.required" => "Please enter an author",
        ];
    }
}
