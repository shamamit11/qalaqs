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
    Route::post('/check-login', 'checkLogin')->name('check-login');
    Route::get('/refresh-token', 'refreshToken');
    Route::post('/register-user', 'registerUser');
    Route::post('/forget-password', 'forgetPassword');
    Route::post('/reset-password', 'resetPassword');
});

Route::get('/banner', 'BannerController@list');

Route::post('/create-special-order', 'SpecialOrderController@createSpecialOrder');

Route::controller('ProductController')->group(function () {
    Route::get('/topDeals/{limit}', 'topDeals');
    Route::get('/featuredProducts', 'featuredProducts');

    Route::get('/make', 'getMakes');
    Route::get('/getModels/{make_id}', 'getModels');
    Route::get('/getYears', 'getYears');
    Route::get('/category', 'getCategories');
    Route::get('/getSubcategory/{category_id}', 'getSubcategories');
    Route::get('/subcategories', 'getAllSubcategories');

    Route::post('/searchResult', 'searchResult');
    Route::get('/product/{id}', 'productDetail');

    Route::get('/other-categories', 'listOtherCategories');
    Route::get('/other-categories-products/{category_id}', 'listProductByOtherCategories');
});

Route::controller('VendorController')->group(function () {
    Route::get('/vendor/{vendor_id}', 'vendorDetail');
    Route::post('/vendor/addReview', 'addReview');
});

Route::group(['middleware' => ['auth.jwt']], function () {

    Route::controller('AccountController')->group(function () {
        Route::get('logout', 'logout');
        Route::get('/profile', 'getProfile');
        Route::post('/update-profile', 'updateProfile');
        Route::get('/cancel-account', 'cancelAccount');
        Route::post('/update-password', 'updatePassword');
        Route::post('/expoPushTokens', 'updatePushToken');
        Route::post('/updateProfileImage', 'updateProfileImage');
        Route::get('/notification', 'notification');
        Route::post('/update-notification', 'updateNotificationStatus');
    });

    Route::controller('TempQuoteItemController')->group(function () {
        Route::get('/temp-quote/{quote_session_id}', 'list');
        Route::post('/temp-quote/addItem', 'addItem');
        Route::post('/temp-quote/deleteItem', 'deleteItem');
    });

    Route::controller('QuoteController')->group(function () {
        Route::post('/quote/createQuote', 'createQuote');
        Route::get('/quote/list', 'list');
        Route::get('/quote/detail/{quote_id}', 'getQuoteDetails');
    });

    Route::controller('ProductInquiryController')->group(function () {
        Route::post('/product/inquiry', 'inquiry');
    });

    Route::controller('AutoServiceController')->group(function () {
        Route::get('/service/garage', 'garage');
        Route::get('/service/recovery', 'recovery');
        Route::get('/service/autoservice', 'autoservice');
        Route::get('/service/auction', 'auction');
    });

    Route::controller('AddressController')->group(function () {
        Route::get('/listaddress', 'list');
        Route::post('/address/addEdit', 'addEdit');
        Route::get('/address/{id}', 'getAddress');
        Route::get('/address-delete/{id}', 'deleteAddress');
    });

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
        Route::post('/order/createOrder', 'createOrder');
        Route::get('/orders', 'listOrders');
        Route::get('/order/detail/{order_id}', 'getOrderDetails');
        Route::get('/orders/recent', 'recentOrders');
        Route::get('/orders/recentDetail/{id}', 'recentOrderDetail');
        Route::post('/orders/createReturns', 'createOrderReturns');
        Route::get('/orders/listReturns', 'listReturns');
        // Route::get('/orders/returns/{return_id}', 'returnDetail');
    });

});