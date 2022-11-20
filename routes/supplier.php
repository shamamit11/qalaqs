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

Route::get('login', 'AuthController@login')->name('supplier-login');
Route::post('check/login', 'AuthController@checkLogin')->name('supplier-checkLogin');
Route::get('forgot-password', 'AuthController@forgotPassword')->name('supplier-forgot-password');
Route::get('register', 'AuthController@register')->name('supplier-register');
Route::post('register', 'AuthController@registerSupplier')->name('supplier-register');
Route::get('verify/{email}', 'AuthController@verify')->name('supplier-verify');
Route::post('verify-supplier', 'AuthController@verifySupplier')->name('verify-supplier');



Route::group(['middleware' => 'supplierauth'], function () {
	Route::get('/', 'DashboardController@index')->name('supplier-dashboard');
	Route::get('logout', 'AuthController@logout')->name('supplier-logout');;
});