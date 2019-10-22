<?php


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/posts', 'PostsController@index')->name('posts.index');
    Route::post('/posts', 'PostsController@store')->name('posts.store');
    Route::delete('/posts/{post}', 'PostsController@destroy')->name('posts.destroy');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
