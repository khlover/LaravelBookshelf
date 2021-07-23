<?php

namespace App\Rules;

use App\Models\Book;
use Illuminate\Contracts\Validation\Rule;

/**
 * DuplicateBook - Checks if there is already a book with the inputs Title AND Author
 */
class DuplicateBook implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @param object $params - Request object from the Request class containing all submitted fields
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Book::where('title', '=', $this->params->title)->where('author', '=', $this->params->author)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Book already exists on bookshelf';
    }
}

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
