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

Auth::routes();

//All Those Routes can be replaced
Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

// By This Line
//Route::resource('threads', 'ThreadController');

Route::get('/threads/{channel}', 'ThreadController@index');


Route::get('/home', 'HomeController@index')->name('home');


Route::post('/replies/{reply}/favorites', 'FavoriteController@storeReply');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroyReply');
Route::post('/threads/{thread}/favorites', 'FavoriteController@storeThread');


Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');
