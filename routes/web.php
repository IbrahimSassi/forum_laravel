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

//All Those Routes can be replaced
Route::post('/threads', 'ThreadController@store');
Route::get('/threads/create', 'ThreadController@create');
Route::get('/threads', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
// By This Line

//Route::resource('threads', 'ThreadController');

Route::get('/threads/{channel}', 'ThreadController@index');


Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();


Route::post('/replies/{reply}/favorites', 'FavoriteController@storeReply');
Route::post('/threads/{thread}/favorites', 'FavoriteController@storeThread');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
