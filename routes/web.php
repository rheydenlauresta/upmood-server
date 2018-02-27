<?php

// use App\Events\MessageRecieved;
// use App\RestModel\Message;
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

Route::get('/test', function () {
    $check = DB::select('SELECT email FROM users WHERE BINARY email = "Admin@taisondigital.com"');
    return count($check);
});

// Route::get('/test', 'HomeController@test');



Route::get('/reset', function () {
    return view('auth/passwords/reset');
});

Auth::routes();

Route::group(['middleware' => ['auth','preventBackHistory']], function (){

	// dashboard
	Route::get('/dashboard', 'DashboardController@index');

	// user

	Route::get('users/userProfile/{id?}', 'UsersController@userProfile');
	Route::get('users/moodStream/{id?}', 'UsersController@moodStream');
	Route::resources([
	    'users' => 'UsersController'
	]);

	// messages
	Route::resources([
	    'messages' => 'MessagesController'
	]);

	Route::get('/', 'DashboardController@index');
});