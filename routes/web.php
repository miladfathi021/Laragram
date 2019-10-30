<?php


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Posts
    Route::get('/posts', 'PostsController@index')->name('posts.index');
    Route::post('/posts', 'PostsController@store')->name('posts.store');
    Route::delete('/posts/{post}', 'PostsController@destroy')->name('posts.destroy');

    // Followings
    Route::post('/followings/{user}', 'FollowingsController@store')->name('followings.store');

    // Followers
    Route::post('/followers/{user}/decline', 'FollowersController@destroy')->name('followers.destroy');
    Route::post('/followers/{user}/accept', 'FollowersController@store')->name('followers.store');

    // Users
    Route::patch('/users/{user}/username', 'UsernameController@update')->name('username.update');

    // Search
    Route::get('/users/search', 'SearchController@show')->name('search.show');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
