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
    Route::post('/check-login', 'checkLogin');
    Route::get('/refresh-token', 'refreshToken');
    Route::post('/register-vendor', 'registerVendor');

    
    // Route::post('forget-password', 'forgetPassword');
    // Route::get('reset-password/{token}', 'resetPassword');
    // Route::post('reset-password', 'savePassword');
});

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::controller('AccountController')->group(function () {
        Route::get('logout', 'logout');
        Route::post('/update-profile', 'updateProfile');
    });
    
});
