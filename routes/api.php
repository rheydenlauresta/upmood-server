<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:admin-api'], function (){

	Route::post('/authenticate/{type}', 'Api\Auth\AuthenticateController@login')->where('type', 'facebook|local');

});

Route::get('testfcm/{token}', 'Api\DeviceTokenController@testfcm');


Route::group(['middleware' => 'auth:api'], function (){

	Route::prefix('user')->middleware(['user-access', 'account-status'])->group(function () {

		Route::post('search', 'Api\UserController@search');

		Route::post('connection/{type?}', 'Api\ConnectionController@connection')
			 ->where('type', 'connect|disconnect|accept');

		Route::get('notification/{type?}/{id?}', 'Api\NotificationController@notification')
		     ->where('type', 'seen|connect|approve|react|status');

		Route::get('resources/{type?}/{mode?}/{set?}', 'Api\ResourcesController@resources')
			 ->where([
			 	'type' => 'emoji|sticker|owned|all', 
			 	'mode' => 'paid|free|emoji|sticker|pancake|gummybear|hotdog|pancake|regular', 
			 	'set' => 'pancake|gummybear|hotdog|pancake|regular'
			 ]);

		Route::resource('profile', 'Api\ProfileController', ['only' => [
		    'show', 'update'
		]]);

		Route::resource('post', 'Api\PostController', ['only' => [
		    'index', 'store'
		]]);

		Route::resource('reaction', 'Api\ReactionController', ['only' => [
		    'index', 'store', 'show'
		]]);

		Route::resource('record', 'Api\RecordController', ['only' => [
		    'index', 'store', 'show'
		]]);


		Route::get('group/search', 'Api\GroupController@search');
		Route::resource('group', 'Api\GroupController', ['only' => [
		    'index', 'store', 'show', 'update'
		]]);

		Route::get('featured/search', 'Api\FeaturedController@search');
		Route::resource('featured', 'Api\FeaturedController', ['only' => [
		    'index', 'store', 'show', 'update'
		]]);


		Route::resource('devices', 'Api\DeviceTokenController', ['only' => [
		    'store'
		]]);


		Route::get('fcmresponse/{type?}', 'Api\DeviceTokenController@fcmResponse');
	});

});
