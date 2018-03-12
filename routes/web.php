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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::resource('site', 'SiteController');

    //Plans
	Route::resource('planadvantage', 'PlanAdvantageController', ['only' => ['index','store','update','destroy']]);
	Route::resource('plan', 'PlanController');

	//Equipment
	Route::resource('equipmenttype', 'EquipmentTypeController', ['except' => ['create', 'edit']]);
	Route::resource('equipmenttype.equipment', 'EquipmentController', ['except' => ['index','create', 'edit']]);
	Route::put('equipmenttype/{equipmenttype}/equipment/{equipment}/affect', 'EquipmentController@affect')->name('equipmenttype.equipment.affect');

});
Route::resource('schedule', 'ScheduleController', ['only' => ['store','destroy']]);