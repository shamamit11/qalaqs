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
	Route::get('logout', 'AuthController@logout')->name('supplier-logout');

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