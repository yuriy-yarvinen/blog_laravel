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

// Route::get('/','HomeController@home')->name('home')->middleware('auth');
Route::get('/','HomeController@home')->name('home');
Route::post('/deleteUser','UserController@deleteUser')->name('deleteUser');
Route::get('/contacts','HomeController@contacts')->name('contacts');

Route::get('/posts/tags/{id}','PostTagController@index')->name('posts.tag.index');
Route::get('/secret','HomeController@secret')->name('secret')->middleware('can:contact.secret');
// Route::resource('/posts','PostController')->only(['index','show','create','store','edit','update']);
// Route::resource('/posts','PostController')->except(['destroy']);
Route::resource('posts','PostController');
Route::resource('posts.comments','BlogPostCommentController')->only(['store']);
Route::resource('users.comments','UserCommentController')->only(['store']);
Route::resource('users','UserController')->only(['show', 'edit', 'update']);

Auth::routes();
