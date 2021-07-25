<?php

namespace Tests\Feature;

use App\Models\Book;
use DOMDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use stdClass;
use Tests\TestCase;

class BooksTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //BOOK STORE TESTS

    /** @test */
    public function book_added_normal()
    {
        $response = $this->post('/books', [
            'title' => 'Test Book',
            'author' => 'Test Author'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book',
            'author' => 'Test Author'
        ]);
    }

    /** @test */
    public function booked_added_special_chars(){
         $response = $this->post('/books', [
            'title' => '希望',
            'author' => 'Arsène Lupin'
        ]);

        $this->assertDatabaseHas('books', [
             'title' => '希望',
            'author' => 'Arsène Lupin'
        ]);

        $this->followRedirects($response)->assertSee('希望');
         $this->followRedirects($response)->assertSee('Arsène Lupin');
    }

    /** @test */
    public function book_added_duplicate_fail()
    {

        $book = factory(Book::class)->create(['title' => 'Test Book', 'author' => 'Test Author']);

        $response = $this->post('/books', [
            'title' => 'Test Book',
            'author' => 'Test Author'
        ]);

        $count = Book::where('title', 'Test Book')->where('author', 'Test Author')->count(0);
        $this->assertEquals(1, $count, "Duplicate book should not be able to be added");
    }

    /** @test */
    public function book_added_field_missing()
    {
        $response = $this->post('/books', [
            'title' => 'Test Book',
            'author' => ''
        ]);

        $this->assertDatabaseMissing('books', [
            'title' => 'Test Title',
            'author' => ''
        ]);
    }

    //EDIT TESTS
    /** @test */
    public function book_edit_normal()
    {
        $book = factory(Book::class)->create();

        $response = $this->post('books/1', [
            'title' => 'Test Book Edited',
            'author' => 'Test Author Edited'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book Edited',
            'author' => 'Test Author Edited'
        ]);
    }

    /** @test */
    public function book_edit_field_missing()
    {
        $book = factory(Book::class)->create();
        $response = $this->post('books/1', [
            'title' => 'Test Book',
            'author' => ''
        ]);

        $this->assertDatabaseMissing('books', [
            'title' => 'Test Title',
            'author' => ''
        ]);
    }

    //TEST SEARCH
    /** @test */
    public function book_search_title()
    {
        factory(Book::class)->create([
            'title' => "Find me",
            'author' => "Find me",
            'bookid' => "1"
        ]);

        factory(Book::class)->create([
            'title' => "Dont Find me",
            'author' => "Test data",
            'bookid' => "2"

        ]);

        $response = $this->get('/books/search/title?_token=waomYiWLIsxtzocFlnejHFndgITmCRAeLj9j7bfc&title=Find+me');
        $response->assertSuccessful("Failed to connect to route");
        $response = $this->followRedirects($response);
        $response->assertSee('Find me', "Search does not show correct data");
        $response->assertDontSee('Dont Find me', "Search appears to not have been executed");
    }

    /** @test */
    public function book_search_author()
    {

        factory(Book::class)->create([
            'title' => "Test title",
            'author' => "Find me",
            'bookid' => "1"
        ]);

        factory(Book::class)->create([
            'title' => "Dont Find me",
            'author' => "Test data",
            'bookid' => "2"

        ]);

        $response = $this->get('books/search/author?_token=waomYiWLIsxtzocFlnejHFndgITmCRAeLj9j7bfc&author=Find+me');
        $response->assertSuccessful("Failed to connect to route");
        $response = $this->followRedirects($response);
        $response->assertSee('Find me', "Search does not show correct data");
        $response->assertDontSee('Dont Find me', "Search appears to not have been executed");
    }

    //TEST SORTING
    /** @test */
    public function sort_normal_title_ascending()
    {
        factory(Book::class)->create(
            [
                'title' => 'apple',
                'author' => 'apple',
                'bookid' => '1'
            ]
        );

        factory(Book::class)->create(
            [
                'title' => 'bannana',
                'author' => 'bannana',
                'bookid' => '2'
            ]
        );

        $response = $this->get('/books?sort=title&direction=asc');
        $response->assertSuccessful("Failed to connect to route");
        $response->assertSeeInOrder(['apple', 'bannana']);
    }

    /** @test */
    public function sort_normal_title_descending()
    {
        factory(Book::class)->create(
            [
                'title' => 'apple',
                'author' => 'apple',
                'bookid' => '1'
            ]
        );

        factory(Book::class)->create(
            [
                'title' => 'bannana',
                'author' => 'bannana',
                'bookid' => '2'
            ]
        );

        $response = $this->get('/books?sort=title&direction=desc');
        $response->assertSuccessful("Failed to connect to route");
        $response->assertSeeInOrder(['bannana', 'apple']);
    }

    /** @test */
    public function sort_normal_author_ascending()
    {
        factory(Book::class)->create(
            [
                'title' => 'apple',
                'author' => 'apple',
                'bookid' => '1'
            ]
        );

        factory(Book::class)->create(
            [
                'title' => 'bannana',
                'author' => 'bannana',
                'bookid' => '2'
            ]
        );

        $response = $this->get('/books?sort=author&direction=asc');
        $response->assertSuccessful("Failed to connect to route");
        $response->assertSeeInOrder(['apple', 'bannana']);
    }

    /** @test */
    public function sort_normal_author_descending()
    {
        factory(Book::class)->create(
            [
                'title' => 'apple',
                'author' => 'apple',
                'bookid' => '1'
            ]
        );

        factory(Book::class)->create(
            [
                'title' => 'bannana',
                'author' => 'bannana',
                'bookid' => '2'
            ]
        );

        $response = $this->get('/books?sort=author&direction=desc');
        $response->assertSuccessful("Failed to connect to route");
        $response->assertSeeInOrder(['bannana', 'apple']);
    }


    //PAGINATION TESTING
    /** @test */
    public function less_than_six_records_check_no_pagination()
    {
        $book = factory(Book::class, 4)->create();
        $response = $this->followingRedirects()->get('/books');
        $response->assertSuccessful("Failed to connect to route");
        $response->assertDontSeeText('&rsaquo', "Pagination should not occur with less than 6 records");
    }


    /** @test */
    public function more_than_five_records_check_pagination()
    {
        $book = factory(Book::class, 100)->create();
        $response = $this->followingRedirects()->get('/books');
        $response->assertSuccessful("Failed to connect to route");
        $response->assertSeeText('&rsaquo', "No Pagination detected");
    }

    //GENERATE XML TESTING
    /** @test */
    public function export_xml_books_generated_correctly()
    {
        $book = factory(Book::class, 5)->create();
        $books = Book::all();

        $obj = $books;
        $field = 'books';

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
        $this->assertEquals(5, $doc->getElementsByTagName('book')->length, "Incorrect number of records");
    }

    /** @test */
    public function export_xml_authors_generated_correctly()
    {
        $book = factory(Book::class, 5)->create();
        $books = DB::table('books')->select('author')->get();

        $obj = $books;
        $field = 'author';

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
        $this->assertEquals(5, $doc->getElementsByTagName('book')->length, "Incorrect number of records");
    }

    /** @test */
    public function export_xml_titles_generated_correctly()
    {
        $book = factory(Book::class, 5)->create();
        $books = DB::table('books')->select('title')->get();

        $obj = $books;
        $field = 'title';

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
        $this->assertEquals(5, $doc->getElementsByTagName('book')->length, "Incorrect number of records");
    }

    //GENERATE CSV TESTING
    /** @test */
    public function export_csv_books_generated_correctly()
    {

        $book = factory(Book::class, 5)->create();
        $obj = DB::table('books')->get();
        $field = "Books";
        $linecount = 0;


        if ($field != "Books") {
            $headers = [$field];
        } else {

            $headers = ['Title', 'Author'];
        }

        $f = fopen('php://output', 'w');


        fputcsv($f, $headers);
        foreach ($obj as $line) {
            if (isset($line)) {
                $linecount++;
                fputcsv($f, get_object_vars($line));
            }
        }

        fclose($f);

        $this->assertEquals(5, $linecount, "Incorrect number of lines in csv file ");
    }

    /** @test */
    public function export_csv_authors_generated_correctly()
    {

        $book = factory(Book::class, 5)->create();
        $obj = DB::table('books')->select('author')->get();
        $field = "author";
        $linecount = 0;


        if ($field != "Books") {
            $headers = [$field];
        } else {

            $headers = ['Title', 'Author'];
        }

        $f = fopen('php://output', 'w');


        fputcsv($f, $headers);
        foreach ($obj as $line) {
            if (isset($line)) {
                $linecount++;
                fputcsv($f, get_object_vars($line));
            }
        }

        fclose($f);

        $this->assertEquals(5, $linecount, "Incorrect number of lines in csv file");
    }

    /** @test */
    public function export_csv_titles_generated_correctly()
    {

        $book = factory(Book::class, 5)->create();
        $obj = DB::table('books')->select('title')->get();
        $field = "title";
        $linecount = 0;


        if ($field != "Books") {
            $headers = [$field];
        } else {

            $headers = ['Title', 'Author'];
        }

        $f = fopen('php://output', 'w');

        fputcsv($f, $headers);
        foreach ($obj as $line) {
            if (isset($line)) {
                $linecount++;
                fputcsv($f, get_object_vars($line));
            }
        }

        fclose($f);

        $this->assertEquals(5, $linecount, "Incorrect number of lines in csv file");
    }


    //TEST DESTROY
    /** @test */
    public function book_destroy()
    {
        $book = factory(Book::class)->create();

        $response = $this->delete('/books/1');

        $this->assertDatabaseMissing('books', [
            'bookid' => '1'
        ]);
    }
}
