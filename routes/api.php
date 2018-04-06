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

});
