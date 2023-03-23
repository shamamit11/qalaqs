<?php

use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller('AuthController')->group(function () {
    Route::post('check-login', 'checkLogin')->name('check-login');
    Route::get('/refresh-token', 'refreshToken');
    Route::post('register-user', 'registerUser');
    // Route::post('forget-password', 'forgetPassword')->name('forget-password');
    // Route::get('reset-password/{token}', 'resetPassword')->name('reset-password');
    // Route::post('reset-password', 'savePassword')->name('save-password');
    Route::get('refresh-token', 'refreshToken')->name('refresh-token');
});

//Route::group(['middleware' => ['auth.jwt']], function () {
    Route::controller('AccountController')->group(function () {
        Route::get('logout', 'logout');
        Route::post('/update-profile', 'updateProfile');
        Route::post('/update-password', 'updatePassword');
    });

    Route::get('/banner', 'BannerController@list');
    Route::controller('ProductController')->group(function () {
        Route::get('/make', 'make');
        Route::get('/model', 'model');
        Route::get('/year', 'year');
        Route::get('/engine', 'engine');
        Route::get('/category', 'category');
        Route::get('/subcategory', 'subcategory');
        Route::get('/product', 'product');
        Route::get('/product/{id}', 'productDetail');
        Route::get('/feature-product', 'featuredProduct');
        Route::get('/landing-page-product', 'landingPageProduct');
    });

//});
