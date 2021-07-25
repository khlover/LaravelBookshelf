<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookInputPost;
use App\Http\Requests\BookSearchAuthor;
use App\Http\Requests\BookSearchTitle;

use App\Http\Controllers\Controller;
use App\Classes\ExportFile;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


/**
 * BookController - Contains all methods related to using the Book Model
 *
 * @category Controllers
 * @author   Jamie Cox <https://github.com/khlover>
 * @package  BookController
 */
class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Returns data of one record from the database
     *
     * @param mixed $id - Chosen records bookId
     *
     * @return void
     */
    function show($id)
    {
        return view('books.edit', ['book' =>  Book::find($id)]);
    }

    /**
     * Returns object of database table to the home view.
     *
     * @return void
     */
    function index()
    {
        return view('books.home', ['books' => Book::sortable()->paginate(5)]);
    }

    /**
     * Searches database for author then returns an object from that filtered table.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    function searchAuthor(BookSearchAuthor $request)
    {
        $author = $request->author;
        $field = "author";
        $books = Book::where('author', 'like', $author)->sortable()->paginate(5);
        return view('books.home', ['books' => $books, 'query' =>  $field . "," . $author]);
    }

    /**
     * Searches database for title then returns an object from that filtered table.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    function searchTitle(BookSearchTitle $request)
    {
        $title = $request->title;
        $books = Book::where('title', 'like', $title)->sortable()->paginate(5);
        return view('books.home', ['books' => $books, 'query' => "title," . $title]);
    }

    /**
     * Opens the create view.
     *
     * @return void
     */
    public function create()
    {
        return view('books.create');
    }


    /**
     * Creates a new record based on request values then inserts it to the database.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    public function store(BookInputPost $request)
    {
        $title = $request->title;
        $author = $request->author;

        $book = new Book();
        $book->title = $title;
        $book->author = $author;
        $book->save();

        return redirect('/books');
    }

    /**
     * Updates record chosen by ID with the data in the request.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    public function editBook(BookInputPost $request)
    {
        $title = $request->title;
        $author = $request->author;
        $id = $request->id;
        $target = Book::find($id);
        $target->update(['title' => $title, 'author' => $author]);

        return redirect('/books');
    }

    /**
     * Destroys record chosen by ID
     *
     * @param mixed $id - Chosen records bookId
     *
     * @return void
     */
    public function destroy($id)
    {
        $target = Book::findOrFail($id);
        $target->delete();
        return redirect('/books');
    }

    /**
     * Sets what fields will be used to generate the CSV,filters by latest search if it exits, then calls external function to perform the task.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    public function exportToCSV(Request $request)
    {
        $field = strtolower($request->field);
        $search = explode(",", $request->search);
        $export = new ExportFile;

        if ($field == 'all') {
            $data = DB::table('books')->when($search[0] != "", function ($query) use ($search) {
                return $query->where($search[0], $search[1]);
            })->get();

            $field = "Book";
        } else {
            $data = DB::table('books')->select($field)->when($search[0] != "", function ($query) use ($search) {
                return $query->where($search[0], $search[1]);
            })->get();
        }

        $export->create_CSV($data, $field);
    }

    /**
     * Sets what fields will be used to generate the XML, filters by latest search if it exists,then calls external function to perform the task.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    public function exportToXML(Request $request)
    {
        $field = strtolower($request->field);
        $search = explode(",", $request->search);
        $export = new ExportFile;

        if ($field == 'all') {
            $data = DB::table('books')->when($search[0] != "", function ($query) use ($search) {
                return $query->where($search[0], $search[1]);
            })->get();

            $field = "Book";
        } else {
            $data = DB::table('books')->select($field)->when($search[0] != "", function ($query) use ($search) {
                return $query->where($search[0], $search[1]);
            })->get();
        }
        $export->create_XML($data, $field);
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
