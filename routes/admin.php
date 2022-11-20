<?php

use Illuminate\Support\Facades\Route;

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
Route::get('login', 'AuthController@login')->name('admin-login');
Route::post('check/login', 'AuthController@checkLogin')->name('admin-checkLogin');
Route::get('forgot-password', 'AuthController@forgotPassword')->name('admin-forgot-password');
Route::group(['middleware' => 'adminauth'], function () {
	Route::get('/', 'DashboardController@index')->name('admin-dashboard');
	Route::get('logout', 'AuthController@logout')->name('admin-logout');;
});