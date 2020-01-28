<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student', 'StudentController@index');
Route::get('/refreshdata', 'StudentController@refresh');
Route::post('/studentadd', 'StudentController@store');
Route::put('/studentupdate/{id}', 'StudentController@update');
Route::delete('/studentdelete/{id}', 'StudentController@destroy');

Route::prefix('product-list')->group(function () {
    Route::get('/', 'ProductController@index');
    Route::get('/{id}/edit', 'ProductController@edit');
    Route::post('/store', 'ProductController@store');
    Route::get('/delete/{id}', 'ProductController@destroy');
});

