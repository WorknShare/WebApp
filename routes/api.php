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

Route::post('login', 'Auth\ApiAdminLoginController@login');
Route::post('logout', 'Auth\ApiAdminLoginController@logout');

Route::group(['middleware' => 'auth:admin-api'], function() {
	Route::get('ticket', 'TicketController@index');
	Route::post('ticket', 'TicketController@store');
	Route::put('ticket/{ticket}', 'TicketController@updateStatus');
});