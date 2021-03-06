<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('my/page', function () {
  return 'Hello world!';
});

Route::get('/books/{genre?}', function ($genre = 'Crime') {
  return "Books in the {$genre} category.";
});

Route::get('/', 'ComicController@index');

Route::get('/{squirrel}', function ($squirrel) {
  $data['squirrel'] = $squirrel;
  return View::make('simple', $data);
});

Route::get('first', function () {
  return 'First route.';
});

Route::get('second', function () {
  return 'Second route.';
});

// Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers(['auth'     => 'Auth\AuthController',
                    'password' => 'Auth\PasswordController',]);
