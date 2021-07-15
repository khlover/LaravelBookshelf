<?php

use App\Http\Controllers\DatabaseAcesss\AddBookController;

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

Route::post('/addbook', function () {
    DB::insert('insert into books (title, author) values (?, ?)', [$_POST['title'], $_POST['author']]);
    return view('welcome');
});




Route::get('/', function () {
    return view('welcome');
});
