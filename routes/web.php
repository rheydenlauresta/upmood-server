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

// Route::get('sample', 'HomeController@sample')->name('hosampme');

// Route::get('/', function () {
//     return view('auth/login');
// });
Route::get('/reset', function () {
    return view('auth/passwords/reset');
});

Auth::routes();

// Route::get('/test', function () {
//     $notifications = Message::where('seen',0)
//     	->leftJoin('users',function($query){
//     		$query->on('users.id','=','contact_message.user_id');
//     	})
//     	->paginate(10);
// // dd($notifications);
//     event( new MessageRecieved( 'notification', $notifications ) );

//     return view('welcome');
// });


Route::group(['middleware' => 'auth'], function (){

	// dashboard
	Route::get('/dashboard', 'DashboardController@index');

	// user

	Route::get('users/userProfile/{id?}', 'UsersController@userProfile');
	Route::resources([
	    'users' => 'UsersController'
	]);

	// messages
	Route::resources([
	    'messages' => 'MessagesController'
	]);

	Route::get('/', 'DashboardController@index');
});