<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Book;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    function selectBooks(Request $request)
    {
        $books = Book::all();
        return view('welcome', ['books' => $books]);
    }

    function sort(Request $request)
    {
        $field = $request->field;
        $books = Book::orderBy($field, 'asc')->get();
        return view('welcome', ['books' => $books]);
    }


    function search()
    {
        $author = $_GET['author'];
        $books = Book::where('author', 'like', $author)->get();
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
        Book::where('bookid', $bookid)->delete();
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

    public function exportToXML(Request $request)
    {
        $field = $request->field;

        if ($field == null) {
            $data = Book::select('title', 'author')->get();
            $field = "Book";
        } else {
            $data = Book::select($field)->get();
        }
        array_to_xml_download($data, $field);
    }
}


function array_to_xml_download($obj, $field)
{
    header('Content-type: text/xml');
    header('Content-Disposition: attachment; filename="text.xml"');

    $doc = new DOMDocument('1.0');
    $doc->formatOutput = true;

    $container = $doc->createElement('container');
    $container = $doc->appendChild($container);

    foreach ($obj as $line) {
        $root = $doc->createElement('book');

        if ($field == "Book" || $field == "title") {
            $title = $doc->createElement('Title', $line->title);
            $title = $root->appendChild($title);
        }

        if ($field == "Book" || $field == "author") {
            $author = $doc->createElement('Author', $line->author);
            $author = $root->appendChild($author);
        }

        $root = $container->appendChild($root);
    }

    $xmldata =  $doc->saveXML();
    echo $xmldata;
    exit();
    return Redirect::to('welcome');
}


function array_to_csv_download($array, $field)
{
    header("Content-Type: application/csv");
    header("Content-Disposition: attachment; filename= " . $field . "s.csv");

    $f = fopen('php://output', 'w');

    foreach ($array as $line) {
        if (isset($line)) {
            fputcsv($f, (array) $line, ':');
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