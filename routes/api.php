<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', 'BooksController@index');
Route::post('/books', 'BooksController@store');
Route::post('/books/{id}/reviews', 'BooksReviewController@store')->middleware('jwt');
Route::delete('/books/{bookId}/reviews/{reviewId}', 'BooksReviewController@destroy')->middleware('jwt');

Route::post('/login','AuhController@login');
Route::post('/logout','AuhController@logout');
Route::post('/register','AuhController@register');
Route::post('/edit','AuhController@update')->middleware('jwt');
