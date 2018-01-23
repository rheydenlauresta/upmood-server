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

Route::get('/dashboard', 'DashboardController@index');

Route::get('/userslist', 'DashboardController@usersList');

Route::post('/usersfilter', 'DashboardController@userFilter');

Route::get('/countryFilter', 'DashboardController@userCountry');
Route::get('/users','DashboardController@usersStatistics');


Route::get('/', 'DashboardController@index');

// Route::get('/user', 'HomeController@users');
