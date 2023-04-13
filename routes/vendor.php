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
    Route::get('login', 'login')->name('vendor-login');
    Route::post('check/login', 'checkLogin')->name('vendor-checkLogin');
    Route::get('forgot-password', 'forgotPassword')->name('vendor-forgot-password');
    Route::get('register', 'register')->name('vendor-register');
    Route::post('register', 'registerSupplier')->name('vendor-register');
    Route::get('verify/{email}', 'verify')->name('vendor-verify');
    Route::post('verify-vendor', 'verifySupplier')->name('verify-vendor');

    Route::get('forgot-password', 'forgotPassword')->name('vendor-forgot-password');
    Route::post('forget-password', 'forgetPassword')->name('vendor-forget-password');
    Route::get('reset-password/{token}', 'resetPassword')->name('vendor-reset-password');
    Route::post('reset-password', 'savePassword')->name('vendor-save-password');
});

Route::group(['middleware' => 'vendorauth'], function () {
    Route::get('/', 'DashboardController@index')->name('vendor-dashboard');
    Route::get('logout', 'AuthController@logout')->name('vendor-logout');

    
    Route::controller('AccountController')->group(function () {
        Route::get('/account', 'index')->name('vendor-account-setting');
        Route::post('/account/addaction', 'addAction')->name('vendor-account-addaction');
        Route::get('/account/change-password', 'changePassword')->name('vendor-account-change-password');
        Route::post('/account/update-password', 'updatePassword')->name('vendor-account-update-password');
        Route::post('/account/imagedelete', 'imageDelete')->name('vendor-account-imagedelete');
        Route::get('/account/bank', 'bank')->name('vendor-account-bank');
        Route::post('/account/bank/addaction', 'updateBank')->name('vendor-account-bank-addaction');
    });

    Route::controller('ProductController')->group(function () {
        Route::get('/product', 'index')->name('vendor-product');
        Route::get('/product/view', 'view')->name('vendor-product-view');
        Route::get('/product/add', 'addEdit')->name('vendor-product-add');
        Route::post('/product/addaction', 'addAction')->name('vendor-product-addaction');
        Route::post('/product/imagedelete', 'imageDelete')->name('vendor-product-imagedelete');
        Route::get('/product/addmatch', 'addMatch')->name('vendor-product-addmatch');
        Route::post('/product/addmatchaction', 'addMatchAction')->name('vendor-product-addmatchaction');
        Route::post('/product/delete_match', 'deleteMatch')->name('vendor-product-match-delete');
    });

    Route::controller('OrderController')->group(function () {
        Route::get('/order', 'index')->name('vendor-orders');
        Route::get('/order/view', 'view')->name('vendor-order-view');
        Route::post('/order/updateaction', 'updateAction')->name('vendor-order-updateaction');
    });

});