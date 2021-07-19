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
Route::post('/books/{id}', [BookController::class, 'editBook']);

Route::get('/books/create', [BookController::class, 'create']);
Route::get('/export/csv/{field?}', [BookController::class, 'exportToCSV']);
Route::get('/export/xml/{field?}', [BookController::class, 'exportToXML']);
Route::get('/sort/{field?}', [BookController::class, 'sort']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/search/author', [BookController::class, 'searchAuthor']);
Route::get('/search/title', [BookController::class, 'searchTitle']);
Route::get('/books', [BookController::class, 'index']);

Route::delete('/books/{id}', [BookController::class, 'destroy']);


//Users should be redirected to home page
Route::get('/', function () {
    return redirect('/books');
});
