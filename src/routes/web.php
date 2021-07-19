<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Controller Calls
Route::post('/books', [BookController::class, 'store']);

Route::post('/edit/{id}', [BookController::class, 'editBook']);

Route::get('/export/csv/{field?}', [BookController::class, 'exportToCSV']);
Route::get('/export/xml/{field?}', [BookController::class, 'exportToXML']);
Route::get('/sort/{field?}', [BookController::class, 'sort']);
Route::get('/edit/{id}', [BookController::class, 'selectBook']);
Route::get('/search/author', [BookController::class, 'searchAuthor']);
Route::get('/search/title', [BookController::class, 'searchTitle']);
Route::get('/books', [BookController::class, 'index']);

Route::delete('/books/{id}', [BookController::class, 'destroy']);


//Navigation
Route::get('/books/create', function () {
    return view('books.create', ['title' => 'Add Book']);
});

Route::get('/', function () {
    return redirect('/books');
});
