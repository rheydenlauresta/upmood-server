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

// Route::get('sample', 'HomeController@sample')->name('hosampme');

// Route::get('/', function () {
//     return view('auth/login');
// });
Route::get('/reset', function () {
    return view('auth/passwords/reset');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// dashboard
Route::get('/dashboard', 'DashboardController@index');

// user

Route::get('users/userProfile/{id?}', 'UsersController@userProfile');
Route::resources([
    'users' => 'UsersController'
]);

// Route::get('/userslist', 'UsersController@usersList');
// Route::get('/usersfilter', 'UsersController@userFilter');

// messages
Route::resources([
    'messages' => 'MessagesController'
]);

Route::get('/', 'DashboardController@index');