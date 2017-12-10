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

Route::group(['middleware' => 'auth:api'], function (){

	Route::post('/authenticate/{type}', 'Api\Auth\AuthenticateController@login')->where('type', 'facebook|local');

	Route::prefix('user')->middleware(['user-access', 'account-status'])->group(function () {

		Route::post('search', 'Api\UserController@search');

		Route::post('connection/{type?}', 'Api\ConnectionController@connection')->where('type', 'connect|disconnect|accept');

	});

});
