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

  //Users
  Route::prefix('/user')->group(function() {
    Route::get('/', 'UserController@indexAdmin')->name('user.index');
    Route::get('/{id}/edit', 'UserController@editAdmin')->name('user.edit_admin');
    Route::put('/{id}', 'UserController@update')->name('user.update_admin');
  });

  //Employees
  Route::resource('employee', 'EmployeeController');
  Route::get('employee/{employee}/editpasswordprompt', 'EmployeeController@editPasswordPrompt')->name('employee.edit_password_prompt');
  Route::get('employee/{employee}/editpassword', 'EmployeeController@editPassword')->name('employee.edit_password');
  Route::post('employee/{employee}/editpassword', 'EmployeeController@updatePassword')->name('employee.update_password');

  //Plans
	Route::resource('planadvantage', 'PlanAdvantageController', ['only' => ['index','store','update','destroy']]);
	Route::resource('plan', 'PlanController');

	//Equipment
	Route::resource('equipmenttype', 'EquipmentTypeController', ['except' => ['create', 'edit']]);
	Route::resource('equipmenttype.equipment', 'EquipmentController', ['except' => ['index','create', 'edit']]);
	Route::put('equipmenttype/{equipmenttype}/equipment/{equipment}', 'EquipmentController@affect')->name('equipmenttype.equipment.affect');

});
Route::resource('schedule', 'ScheduleController', ['only' => ['store','destroy']]);

Route::prefix('myaccount')->group(function(){
  Route::get('/QrCode', 'UserController@showQrCode')->name('myaccount.qrcode');
  Route::get('/pwd', 'UserController@editPassword')->name('myaccount.editpwd');
  Route::put('/pwd', 'UserController@updatePwd')->name('myaccount.updatepwd');
  Route::get('/QrCodeImage', 'UserController@qrcodeAccess')->name('myaccount.qrcodedisplay');
  Route::get('/QrCodeDownload', 'UserController@qrcodedownload')->name('myaccount.qrcodedownload');
});

//Plans
Route::resource('planadvantage', 'PlanAdvantageController', ['only' => ['index','store','update','destroy']]);
Route::resource('plan', 'PlanController');

Route::resource('myaccount', 'UserController');
