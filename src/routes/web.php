<?php

use App\Http\Controllers\DatabaseUse\AddBookController;
use App\Http\Controllers\DatabaseUse\DeleteBookController;
use App\Http\Controllers\DatabaseUse\GetBooksController;
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

Route::post('/addbook', [AddBookController::class, 'add']);
Route::post('/delete/{id}', [DeleteBookController::class, 'delete']);

Route::get('/', [GetBooksController::class, 'getBooks']);
