<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function book_added_duplicate_fail()
    {

        $book = factory(Book::class)->create();

        $response = $this->post('/books', [
            'title' => 'Test Book',
            'author' => 'Test Author'
        ]);

        $count = Book::where('title', 'Test Book')->where('author', 'Test Author')->count(0);
        $this->assertEquals(1, $count);
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
    /*   public function book_search_title()
    {
        factory(Book::class)->create([
            'title' => "Find me",
            'bookid' => "1"
        ]);

        factory(Book::class)->create([
            'title' => "Dont Find me",
            'bookid' => "2"

        ]);

        $response = $this->get('/books/search/title', ['title' => "Find me"]);

        $this->assertEquals($response, ("test"));
    } */

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
