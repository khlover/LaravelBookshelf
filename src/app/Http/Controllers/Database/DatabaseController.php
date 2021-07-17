<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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

    public function exportToCSV(Request $request)
    {
        $field = $request->field;

        if ($field == null) {
            $data = DB::table('books')->select('title', 'author')->get();
            $field = "Book";
        } else {
            $data = DB::table('books')->select($field)->get();
        }
        array_to_csv_download($data, $field);
    }
}


function array_to_csv_download($array, $field)
{
    header("Content-Type: application/csv");
    header("Content-Disposition: attachment; filename= " . $field . "s.csv");

    $f = fopen('php://output', 'w');

    foreach ($array as $line) {
        if (isset($line)) {
            fputcsv($f, (array) $line, '-');
        }
    }

    fclose($f);
    return Redirect::to('welcome');
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
