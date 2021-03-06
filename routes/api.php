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
	Route::get('employee/tech', 'EmployeeController@tech');
	Route::get('ticket', 'TicketController@index');
	Route::get('ticket/all', 'TicketController@all');
	Route::post('ticket', 'TicketController@store');
	Route::put('ticket/{ticket}', 'TicketController@updateStatus');
	Route::put('ticket/{ticket}/affect', 'TicketController@affect');
	Route::get('ticket/equipment/{equipment}', 'TicketController@forEquipment');
	Route::get('equipmenttype/equipment', 'EquipmentController@indexApp');
	Route::get('equipmenttype/getequipmenttype', 'EquipmentTypeController@getEquipmentType');
});
