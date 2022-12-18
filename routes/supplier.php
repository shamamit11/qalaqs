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
    Route::get('login', 'login')->name('supplier-login');
    Route::post('check/login', 'checkLogin')->name('supplier-checkLogin');
    Route::get('forgot-password', 'forgotPassword')->name('supplier-forgot-password');
    Route::get('register', 'register')->name('supplier-register');
    Route::post('register', 'registerSupplier')->name('supplier-register');
    Route::get('verify/{email}', 'verify')->name('supplier-verify');
    Route::post('verify-supplier', 'verifySupplier')->name('verify-supplier');

    Route::get('forgot-password', 'forgotPassword')->name('supplier-forgot-password');
    Route::post('forget-password', 'forgetPassword')->name('supplier-forget-password');
    Route::get('reset-password/{token}', 'resetPassword')->name('supplier-reset-password');
    Route::post('reset-password', 'savePassword')->name('supplier-save-password');
});

Route::group(['middleware' => 'supplierauth'], function () {
    Route::get('/', 'DashboardController@index')->name('supplier-dashboard');
    Route::get('logout', 'AuthController@logout')->name('supplier-logout');

    
    Route::controller('AccountController')->group(function () {
        Route::get('/account', 'index')->name('supplier-account-setting');
        Route::post('/account/addaction', 'addAction')->name('supplier-account-addaction');
        Route::get('/account/change-password', 'changePassword')->name('supplier-account-change-password');
        Route::post('/account/update-password', 'updatePassword')->name('supplier-account-update-password');
    });

    Route::controller('ProductController')->group(function () {
        Route::get('/product', 'index')->name('supplier-product');
        Route::post('/product/status', 'status')->name('supplier-product-status');
        Route::get('/product/add', 'addEdit')->name('supplier-product-add');
        Route::post('/product/addaction', 'addAction')->name('supplier-product-addaction');
        Route::post('/product/imagedelete', 'imageDelete')->name('supplier-product-imagedelete');
        Route::post('/product/delete', 'delete')->name('supplier-product-delete');
        Route::post('/product/specification', 'specification')->name('supplier-product-specification');
        Route::post('/product/addspecification', 'addSpecification')->name('supplier-product-addspecification');
        Route::post('/product/match', 'match')->name('supplier-product-match');
        Route::post('/product/addmatch', 'addMatch')->name('supplier-product-addmatch');
        Route::post('/product/images', 'images')->name('supplier-product-images');
        Route::post('/product/addimages', 'addImages')->name('supplier-product-addimages');
        Route::post('/product/imagesdelete', 'imagesDelete')->name('supplier-product-imagesdelete');

    });

});
