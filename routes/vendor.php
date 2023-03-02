<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller('AuthController')->group(function () {
    Route::post('check-login', 'checkLogin')->name('check-login');
    // Route::post('forget-password', 'forgetPassword')->name('forget-password');
    // Route::get('reset-password/{token}', 'resetPassword')->name('reset-password');
    // Route::post('reset-password', 'savePassword')->name('save-password');
    Route::get('refresh-token', 'refreshToken')->name('refresh-token');
});

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::controller('AuthController')->group(function () {
        Route::get('logout', 'logout');
    });
	Route::get('/banner', 'BannerController@list');
});
