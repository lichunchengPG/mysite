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

Route::get('/','StaticPagesController@home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
Route::get('/signup','UsersController@create')->name('signup');
resource('users','UsersController');

//等同于：
/*
get('/users', 'UsersController@index')->name('users.index');
get('/users/{id}', 'UsersController@show')->name('users.show');
get('/users/create', 'UsersController@create')->name('users.create');
post('/users', 'UsersController@store')->name('users.store');
get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
patch('/users/{id}', 'UsersController@update')->name('users.update');
delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');
*/
Route::get('/login','SessionsController@create')->name('login');
Route::post('/login','SessionsController@store')->name('login');
Route::delete('/logout','SessionsController@destory')->name('logout');
Route::get('signup/comfirm/{token}','UsersController@confirmEmail')->name('confirm_email');
Route::get('password/email','Auth\PasswordController@getEmail')->name('password.reset');
Route::post('password/email','Auth\PasswordController@postEmail')->name('password.reset');
Route::get('password/reset/{token}','Auth\PasswordController@getReset')->name('password.edit');
Route::post('password/reset','Auth\PasswordController@postReset')->name('password.update');
resource('statuses','StatusesController',['only'=>['store','destroy']]);
