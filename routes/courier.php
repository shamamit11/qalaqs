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
Route::controller('AuthController')->group(function () {
    Route::get('/login', 'login')->name('courier-login');
    Route::post('check/login', 'checkLogin')->name('courier-checkLogin');
    Route::get('forgot-password', 'forgotPassword')->name('courier-forgot-password');
    Route::post('forget-password', 'forgetPassword')->name('courier-forget-password');
    Route::get('reset-password/{token}', 'resetPassword')->name('courier-reset-password');
    Route::post('reset-password', 'savePassword')->name('courier-save-password');
});

Route::group(['middleware' => 'courierauth'], function () {
    Route::get('/', 'DashboardController@index')->name('courier-dashboard');
    Route::get('/logout', 'AuthController@logout')->name('courier-logout');

    Route::controller('AccountController')->group(function () {
        Route::get('/account', 'index')->name('courier-account-setting');
        Route::post('/account/addaction', 'addAction')->name('courier-account-addaction');
        Route::get('/account/change-password', 'changePassword')->name('courier-account-change-password');
        Route::post('/account/update-password', 'updatePassword')->name('courier-account-update-password');
        Route::post('/account/imagedelete', 'imageDelete')->name('courier-account-imagedelete');
        Route::get('/account/bank', 'bank')->name('courier-account-bank');
        Route::post('/account/bank/addaction', 'updateBank')->name('courier-account-bank-addaction');
    });
});