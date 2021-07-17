<?php

namespace App\Http\Controllers\DatabaseUse;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddBookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function add()
    {
        console_log("Deleted");
        $title = $_POST['title'];
        $author = $_POST['author'];

        DB::table('books')->insert([
            'title' => $title,
            'author' => $author
        ]);

        return redirect('/');
    }
}
