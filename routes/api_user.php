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

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::controller('AccountController')->group(function () {
        Route::get('logout', 'logout');
        Route::get('/profile', 'getProfile');
        Route::post('/update-profile', 'updateProfile');
        Route::post('/update-password', 'updatePassword');
    });

    Route::post('user-add-address', 'AddressController@addAddress');
    Route::get('user-address', 'AddressController@list');

    Route::controller('CartController')->group(function () {
        Route::get('/cart/{cart_session_id}', 'list');
        Route::post('/cart/addItem', 'addItem');
        Route::post('/cart/updateQty', 'updateQty');
        Route::post('/cart/deleteItem', 'deleteItem');
        Route::get('/cart/items/{cart_session_id}', 'itemCount');
        Route::post('/cart/applyPromocode', 'applyPromocode');
        Route::get('/cart/summary/{cart_session_id}', 'cartSummary');
    });

    Route::controller('OrderController')->group(function () {
        Route::post('/order/generatePaymentToken', 'generatePaymentToken');
        Route::post('/order/processPayment', 'processPayment');
        Route::get('/orders', 'listOrders');
        Route::get('/order/detail/{order_id}', 'getOrderDetails');
        Route::get('/orders/recent', 'recentOrders');
        Route::get('/orders/recentDetail/{id}', 'recentOrderDetail');
        Route::post('/orders/createReturns', 'createOrderReturns');
    });

});
Route::controller('VendorController')->group(function () {
    Route::get('/vendor/{vendor_id}', 'vendorDetail');
    Route::post('/vendor/addReview', 'addReview');
});

Route::controller('ProductController')->group(function () {
    Route::get('/make', 'make');
    Route::get('/model', 'model');
    Route::get('/year', 'year');
    Route::get('/engine', 'engine');
    Route::get('/category', 'category');
    Route::get('/subcategory', 'subcategory');
    Route::post('/search-product', 'product');
    Route::get('/product/{id}', 'productDetail');
    Route::get('/feature-product', 'featuredProduct');
    Route::get('/landing-page-product', 'landingPageProduct');
    Route::get('/other-categories', 'listOtherCategories');
    Route::get('/other-categories-products/{category_id}', 'listProductByOtherCategories');
});

Route::get('/banner', 'BannerController@list');