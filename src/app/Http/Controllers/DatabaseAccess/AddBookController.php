<?php

namespace App\Http\Controllers\DatabaseAccess;

use App\Http\Controllers\Controller;

class AddBookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function add()
    {
        $title = $_POST['title'];
        $author = $_POST['author'];
        DB::insert('insert into books (title, author) values (?, ?)', [$title, $author]);
    }
}
