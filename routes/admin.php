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
    Route::get('logout', 'AuthController@logout')->name('admin-logout');

    Route::controller('SupplierController')->group(function () {
        Route::get('/supplier', 'index')->name('admin-supplier');
        Route::post('/supplier/status', 'status')->name('admin-supplier-status');
        Route::get('/supplier/add', 'addEdit')->name('admin-supplier-add');
        Route::post('/supplier/addaction', 'addAction')->name('admin-supplier-addaction');
        Route::post('/supplier/delete', 'delete')->name('admin-supplier-delete');
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
        Route::post('/category/imagedelete', 'imageDelete')->name('admin-category-imagedelete');
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
        Route::post('/brand/imagedelete', 'imageDelete')->name('admin-brand-imagedelete');
        Route::post('/brand/delete', 'delete')->name('admin-brand-delete');
    });

    Route::controller('MakeController')->group(function () {
        Route::get('/make', 'index')->name('admin-make');
        Route::post('/make/status', 'status')->name('admin-make-status');
        Route::get('/make/add', 'addEdit')->name('admin-make-add');
        Route::post('/make/addaction', 'addAction')->name('admin-make-addaction');
        Route::post('/make/imagedelete', 'imageDelete')->name('admin-make-imagedelete');
        Route::post('/make/delete', 'delete')->name('admin-make-delete');
    });

    Route::controller('ModelController')->group(function () {
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

    Route::controller('SupplierController')->group(function () {
        Route::get('/supplier', 'index')->name('admin-supplier');
        Route::post('/supplier/status', 'status')->name('admin-supplier-status');
        Route::post('/supplier/delete', 'delete')->name('admin-supplier-delete');
    });

});
