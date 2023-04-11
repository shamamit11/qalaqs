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
    Route::get('login', 'login')->name('admin-login');
    Route::post('check/login', 'checkLogin')->name('admin-checkLogin');
    Route::get('forgot-password', 'forgotPassword')->name('admin-forgot-password');
    Route::post('forget-password', 'forgetPassword')->name('admin-forget-password');
    Route::get('reset-password/{token}', 'resetPassword')->name('admin-reset-password');
    Route::post('reset-password', 'savePassword')->name('admin-save-password');
});

Route::group(['middleware' => 'adminauth'], function () {
    Route::get('/', 'DashboardController@index')->name('admin-dashboard');
    Route::get('logout', 'AuthController@logout')->name('admin-logout');

    Route::controller('FilemanagerController')->group(function () {
        Route::get('/filemanager', 'index')->name('admin-filemanager');
    });
    
    Route::controller('AccountController')->group(function () {
        Route::get('/account', 'index')->name('admin-account-setting');
        Route::post('/account/addaction', 'addAction')->name('admin-account-addaction');
        Route::get('/account/change-password', 'changePassword')->name('admin-account-change-password');
        Route::post('/account/update-password', 'updatePassword')->name('admin-account-update-password');
    });
    
    Route::controller('BannerController')->group(function () {
        Route::get('/banner', 'index')->name('admin-banner');
        Route::post('/banner/status', 'status')->name('admin-banner-status');
        Route::get('/banner/add', 'addEdit')->name('admin-banner-add');
        Route::post('/banner/addaction', 'addAction')->name('admin-banner-addaction');
        Route::post('/banner/imagedelete', 'imageDelete')->name('admin-banner-imagedelete');
        Route::post('/banner/delete', 'delete')->name('admin-banner-delete');
    });

    Route::controller('CategoryController')->group(function () {
        Route::get('/category', 'index')->name('admin-category');
        Route::post('/category/status', 'status')->name('admin-category-status');
        Route::get('/category/add', 'addEdit')->name('admin-category-add');
        Route::post('/category/addaction', 'addAction')->name('admin-category-addaction');
        Route::post('/category/delete', 'delete')->name('admin-category-delete');
    });

    Route::controller('SubcategoryController')->group(function () {
        Route::get('/subcategory', 'index')->name('admin-subcategory');
        Route::post('/subcategory/status', 'status')->name('admin-subcategory-status');
        Route::get('/subcategory/add', 'addEdit')->name('admin-subcategory-add');
        Route::post('/subcategory/addaction', 'addAction')->name('admin-subcategory-addaction');
        Route::post('/subcategory/imagedelete', 'imageDelete')->name('admin-subcategory-imagedelete');
        Route::post('/subcategory/delete', 'delete')->name('admin-subcategory-delete');
    });

    Route::controller('BrandController')->group(function () {
        Route::get('/brand', 'index')->name('admin-brand');
        Route::post('/brand/status', 'status')->name('admin-brand-status');
        Route::get('/brand/add', 'addEdit')->name('admin-brand-add');
        Route::post('/brand/addaction', 'addAction')->name('admin-brand-addaction');
        Route::post('/brand/delete', 'delete')->name('admin-brand-delete');
    });

    Route::controller('MakeController')->group(function () {
        Route::get('/make', 'index')->name('admin-make');
        Route::post('/make/status', 'status')->name('admin-make-status');
        Route::get('/make/add', 'addEdit')->name('admin-make-add');
        Route::post('/make/addaction', 'addAction')->name('admin-make-addaction');
        Route::post('/make/delete', 'delete')->name('admin-make-delete');
    });

    Route::controller('ModelsController')->group(function () {
        Route::get('/model', 'index')->name('admin-model');
        Route::post('/model/status', 'status')->name('admin-model-status');
        Route::get('/model/add', 'addEdit')->name('admin-model-add');
        Route::post('/model/addaction', 'addAction')->name('admin-model-addaction');
        Route::post('/model/delete', 'delete')->name('admin-model-delete');
    });

    Route::controller('YearController')->group(function () {
        Route::get('/year', 'index')->name('admin-year');
        Route::post('/year/status', 'status')->name('admin-year-status');
        Route::get('/year/add', 'addEdit')->name('admin-year-add');
        Route::post('/year/addaction', 'addAction')->name('admin-year-addaction');
        Route::post('/year/delete', 'delete')->name('admin-year-delete');
    });

    Route::controller('EngineController')->group(function () {
        Route::get('/engine', 'index')->name('admin-engine');
        Route::post('/engine/status', 'status')->name('admin-engine-status');
        Route::get('/engine/add', 'addEdit')->name('admin-engine-add');
        Route::post('/engine/addaction', 'addAction')->name('admin-engine-addaction');
        Route::post('/engine/delete', 'delete')->name('admin-engine-delete');
    });

    Route::controller('VendorController')->group(function () {
        Route::get('/vendors', 'index')->name('admin-vendor');
        Route::get('/vendors/view', 'view')->name('admin-vendor-view');
        Route::post('/vendors/status', 'status')->name('admin-vendor-status');
    });

    Route::controller('UserController')->group(function () {
        Route::get('/customers', 'index')->name('admin-users');
        Route::get('/customers/view', 'view')->name('admin-users-view');
        Route::post('/customers/status', 'status')->name('admin-users-status');
    });

    Route::controller('ProductController')->group(function () {
        Route::get('/product', 'index')->name('admin-product');
        Route::get('/product/view', 'view')->name('admin-product-view');
        Route::post('/product/status', 'status')->name('admin-product-status');
        Route::post('/product/delete', 'delete')->name('admin-product-delete');
    });

    Route::controller('OrderController')->group(function () {
        Route::get('/orders', 'index')->name('admin-orders');
        Route::get('/order/view', 'view')->name('admin-order-view');
        Route::get('/returns', 'returns')->name('admin-returns');
        Route::get('/return/view', 'returnView')->name('admin-return-view');
        Route::post('/return/status', 'returnStatus')->name('admin-return-status');
    });

});
