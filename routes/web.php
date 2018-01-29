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
Route::get('/userslist', 'UsersController@usersList');
Route::get('/usersfilter', 'UsersController@userFilter');

// messages

Route::get('/messages', function () {
    return view('messages');
});


Route::get('/', 'DashboardController@index');