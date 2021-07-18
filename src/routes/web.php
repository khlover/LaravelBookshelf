<?php

use App\Http\Controllers\Database\BookController;
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
Route::post('/addbook', [BookController::class, 'insertBook']);
Route::post('/delete/{id}', [BookController::class, 'deleteBook']);
Route::post('/edit/{id}', [BookController::class, 'editBook']);
Route::post('/search/{field}', [BookController::class, 'search']);

Route::get('/export/csv/{field?}', [BookController::class, 'exportToCSV']);
Route::get('/sort/{field?}', [BookController::class, 'sort']);
Route::get('/', [BookController::class, 'selectBooks']);

//Navigation
Route::get('/add', function () {
    return view('add', ['title' => 'Add Book']);
});
