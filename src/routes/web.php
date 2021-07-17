<?php

use App\Http\Controllers\Database\DatabaseController;
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

Route::post('/addbook', [DatabaseController::class, 'insertBook']);
Route::post('/delete/{id}', [DatabaseController::class, 'deleteBook']);
Route::get('/export/csv', [DatabaseController::class, 'exportToCSV']);

Route::get('/', [DatabaseController::class, 'selectBooks']);
