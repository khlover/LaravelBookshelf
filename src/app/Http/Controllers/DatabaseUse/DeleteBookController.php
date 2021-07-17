<?php

namespace App\Http\Controllers\DatabaseUse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteBookController extends Controller
{
    public function delete(Request $request)
    {
        $bookid = $request->id;
        DB::table('books')->where('bookid', $bookid)->delete();
        return redirect('/');
    }
}
