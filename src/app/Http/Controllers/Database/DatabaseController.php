<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    function selectBooks()
    {
        $books = DB::table('books')->get();
        return view('welcome', ['books' => $books]);
    }

    public function insertBook()
    {
        $title = $_POST['title'];
        $author = $_POST['author'];

        DB::table('books')->insert([
            'title' => $title,
            'author' => $author
        ]);

        return redirect('/');
    }


    public function deleteBook(Request $request)
    {
        $bookid = $request->id;
        DB::table('books')->where('bookid', $bookid)->delete();
        return redirect('/');
    }
}
