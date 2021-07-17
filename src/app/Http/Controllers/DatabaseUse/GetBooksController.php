<?php

namespace App\Http\Controllers\DatabaseUse;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetBooksController extends Controller
{
    function getBooks()
    {
        $books = DB::table('books')->get();
        return view('welcome', ['books' => $books]);
    }
}
