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

Route::get('/', 'PlanController@indexPublic')->name('welcome');
Auth::routes();

Route::prefix('admin')->group(function() {

  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
  Route::get('/', 'AdminController@index')->name('admin.home');
  Route::resource('site', 'SiteController');
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
  Route::get('/', 'AdminController@index')->name('admin.home');
  Route::resource('site', 'SiteController');
  Route::resource('typeOfRooms', 'TypeOfRoomController');
  Route::resource('meal', 'MealController');
  Route::put('site/{site}/affectmeal', 'SiteController@affectMeal')->name('site.affectmeal');
  Route::put('site/{site}/removemeal', 'SiteController@removeMeal')->name('site.removemeal');

  //Users
  Route::prefix('/user')->group(function() {
    Route::get('/', 'UserController@indexAdmin')->name('user.index');
    Route::get('/{id}/edit', 'UserController@editAdmin')->name('user.edit_admin');
    Route::put('/{id}', 'UserController@update')->name('user.update_admin');
    Route::delete('/{id}', 'UserController@destroyAdmin')->name('user.ban');
    Route::put('/unban/{id}', 'UserController@unban')->name('user.unban');
    Route::put('/update/{myaccount}', 'UserController@updateAdmin')->name('user.update');
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
	Route::put('equipmenttype/{equipmenttype}/equipment/{equipment}/affect', 'EquipmentController@affect')->name('equipmenttype.equipment.affect');
  Route::get('equipmenttype/{equipmenttype}/equipment/{equipment}/calendar', 'EquipmentController@calendar')->name('equipmenttype.equipment.calendar');

  Route::get('order', 'ReserveRoomController@indexAdmin')->name('order.index_admin');
  Route::get('/{order}/order', 'ReserveRoomController@showAdmin')->name('order.show_admin');

  Route::delete('/{id}', 'ReserveRoomController@destroyAdmin')->name('order.destroy_admin');

  //Metrics
  Route::prefix('metrics')->group(function() {

    Route::get('/planspie', 'AdminController@metricsPlanPie')->name('admin.metrics.planspie');
    Route::get('/plans', 'AdminController@metricsPlan')->name('admin.metrics.plans');
    Route::get('/reserve', 'AdminController@metricsReserve')->name('admin.metrics.reserve');

  });

});
Route::resource('schedule', 'ScheduleController', ['only' => ['store','destroy']]);

Route::prefix('myaccount')->group(function(){
  Route::get('/QrCode', 'UserController@showQrCode')->name('myaccount.qrcode');
  Route::get('/pwd', 'UserController@editPassword')->name('myaccount.editpwd');
  Route::put('/pwd', 'UserController@updatePwd')->name('myaccount.updatepwd');
  Route::get('/QrCodeImage', 'UserController@qrcodeAccess')->name('myaccount.qrcodedisplay');
  Route::get('/QrCodeDownload', 'UserController@qrcodedownload')->name('myaccount.qrcodedownload');
  Route::get('planhistory', 'PlanController@planHistory')->name('plan.history');
});

Route::resource('order', 'ReserveRoomController', ['except' => ['edit','update']]);
Route::get('/{type}/{id_site}/order', 'ReserveRoomController@getEquipment')->name('order.getEquipment');
Route::get('orderhistory', 'ReserveRoomController@indexHistory')->name('order.history');

Route::resource('mealorder', 'ReserveMealController', ['except' => ['show', 'edit', 'update']]);
Route::get('getMeal/{meal}', 'ReserveMealController@getMeal')->name('mealorder.getmeal');



//Plans
Route::get('plans', 'PlanController@choose')->name('plan.choose');
Route::get('plans/{plan}', 'PlanController@payment')->name('plan.payment');
Route::post('plans/{plan}', 'PlanController@paymentSend')->name('plan.payment');
Route::get('paymentaccepted', function() {
  if(!session()->has('commandNumber')) abort(404);
  return view('payment_accepted');
})->name('payment_accepted');

Route::resource('myaccount', 'UserController', ['except' => ['destroy']]);
Route::resource('room', 'RoomController', ['except' => ['index', 'create']]);
Route::get('room/calendar/{id}', 'RoomController@calendar')->name('room.calendar');