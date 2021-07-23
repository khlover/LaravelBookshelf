<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookInputPost;
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
    function searchAuthor(Request $request)
    {
        $author = $request->author;
        $books = Book::where('author', 'like', $author)->sortable()->paginate(5);
        return view('books.home', ['books' => $books]);
    }

    /**
     * Searches database for title then returns an object from that filtered table.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    function searchTitle(Request $request)
    {
        $title = $request->title;
        $books = Book::where('title', 'like', $title)->sortable()->paginate(5);
        return view('books.home', ['books' => $books]);
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
    public function editBook(Request $request)
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
     * Sets what fields will be used to generate the CSV, then calls external function to perform the task.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    public function exportToCSV(Request $request)
    {
        $field = $request->field;
        $export = new ExportFile;

        if ($field == null) {
            $data = DB::table('books')->select('title', 'author')->get();
            $field = "Book";
        } else {
            $data = DB::table('books')->select($field)->get();
        }
        $export->create_CSV($data, $field);
    }

    /**
     * Sets what fields will be used to generate the XML, then calls external function to perform the task.
     *
     * @param mixed $request - Contains both GET and POST values.
     *
     * @return void
     */
    public function exportToXML(Request $request)
    {
        $field = $request->field;
        $export = new ExportFile;

        if ($field == null) {
            $data = Book::select('title', 'author')->get();
            $field = "Book";
        } else {
            $data = Book::select($field)->get();
        }
        $export->create_XML($data, $field);
    }
}
