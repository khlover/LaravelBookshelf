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
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::post('/books/{id}', [BookController::class, 'editBook'])->name('books.edit');

Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::get('/export/csv/{search?}', [BookController::class, 'exportToCSV'])->name('books.export-csv');
Route::get('/export/xml/{search?}', [BookController::class, 'exportToXML'])->name('books.export-xml');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/search/{author?}', [BookController::class, 'searchAuthor'])->name('books.search-author');
Route::get('/search/title', [BookController::class, 'searchTitle'])->name('books.search-title');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');


//Users should be redirected to home page
Route::get('/', function () {
    return redirect('/books');
});
