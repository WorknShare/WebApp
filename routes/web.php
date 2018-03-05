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
});
Route::resource('schedule', 'ScheduleController', ['only' => ['store','destroy']]);

Route::prefix('myaccount')->group(function(){
  Route::get('/QrCode', 'UserController@showQrCode')->name('myaccount.qrcode');
  Route::get('/{id}/editpassword', 'UserController@editPassword')->name('myaccount.editpwd');
  Route::put('/pwd/{updatePwd}', 'UserController@updatePwd')->name('myaccount.updatepwd');
});
Route::resource('myaccount', 'UserController');
