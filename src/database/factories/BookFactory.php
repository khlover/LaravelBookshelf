<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {

    return [
        'title' => 'Test Title',
        'author' => 'Test Author',
        'bookid' => '1'
    ];
});
