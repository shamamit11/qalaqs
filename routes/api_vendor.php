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
        Route::post('/update-password', 'updatePassword');
    });

    Route::controller('ProductController')->group(function () {
        Route::controller('ProductController')->group(function () {
            Route::get('/make', 'make');
            Route::get('/model', 'model');
            Route::get('/year', 'year');
            Route::get('/engine', 'engine');
            Route::get('/category', 'category');
            Route::get('/subcategory', 'subcategory');
            Route::get('/products', 'list');
            Route::get('/product/{id}', 'productDetail');
            Route::post('/product/addEdit', 'addEdit');
            Route::post('/product/delete/{id}', 'deleteProduct');
        });

        // Route::get('/product', 'index')->name('supplier-product');
        // Route::post('/product/status', 'status')->name('supplier-product-status');
        // Route::get('/product/add', 'addEdit')->name('supplier-product-add');
        // Route::post('/product/addaction', 'addAction')->name('supplier-product-addaction');
        // Route::post('/product/imagedelete', 'imageDelete')->name('supplier-product-imagedelete');
        // Route::post('/product/delete', 'delete')->name('supplier-product-delete');
        // Route::post('/product/specification', 'specification')->name('supplier-product-specification');
        // Route::post('/product/addspecification', 'addSpecification')->name('supplier-product-addspecification');
        // Route::delete('/product/delete_specification', 'deleteSpecification')->name('supplier-product-specification-delete');
        // Route::post('/product/match', 'match')->name('supplier-product-match');
        // Route::post('/product/addmatch', 'addMatch')->name('supplier-product-addmatch');
        // Route::delete('/product/delete_smatch', 'deleteMatch')->name('supplier-product-match-delete');
        
        // Route::post('/product/images', 'images')->name('supplier-product-images');
        // Route::post('/product/save-images', 'saveImage')->name('supplier-product-saveimage');
        // Route::post('/product/order-images', 'orderImage')->name('supplier-product-orderimage');
        // Route::post('/product/image-status', 'imageStatus')->name('supplier-image-status');
        // Route::post('/product/imagedelete', 'imageDelete')->name('supplier-product-imagedelete');

    });
    
});
