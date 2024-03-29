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
    Route::post('/upload-vendor-docs', 'uploadVendorDocs');
    Route::post('/add-vendor-bankinfo', 'addVendorBankInfo');
    Route::post('/send-email-to-vendor', 'sendEmailToVendor');
    Route::post('/add-vendor-make', 'addVendorMakeData');
    Route::post('/forget-password', 'forgetPassword');
    Route::post('/reset-password', 'resetPassword');
});

Route::controller('ProductController')->group(function () {
    Route::get('/getMakesData', 'getMakes');
    Route::get('/getYearsData', 'getYears');
});

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::controller('AccountController')->group(function () {
        Route::get('logout', 'logout');
        Route::get('/cancel-account', 'cancelAccount');
        Route::post('/update-profile', 'updateProfile');
        Route::post('/update-password', 'updatePassword');
        Route::get('/bank', 'getBankDetail');
        Route::post('/update-bank', 'updateBank');
        Route::post('/expoPushTokens', 'updatePushToken');
        Route::post('/updateProfileImage', 'updateProfileImage');
    });

    Route::controller('ProductController')->group(function () {
        Route::get('/make', 'getMakes');
        Route::get('/getModels/{make_id}', 'getModels');
        Route::get('/getYears', 'getYears');
        Route::get('/getEngines/{make_id}/{model_id}/{year_id}', 'getEngines');
        Route::get('/brand', 'brand');
        Route::get('/category', 'category');
        Route::get('/getSubcategory/{category_id}', 'getSubcategory');
        Route::get('/products', 'list');
        Route::get('/product/{id}', 'productDetail');
        Route::post('/product/addEdit', 'addEdit');
        Route::post('/product/delete/{id}', 'deleteProduct');
        Route::get('/product/suitable/{prod_id}', 'productSuitable');
        Route::post('/product/suitable/add', 'addSuitable');
        Route::post('/product/deleteSuitable/{id}', 'deleteSuitable');
    });

    Route::controller('VendorController')->group(function () {
        Route::get('/profile', 'vendorDetail');
        Route::get('/stats', 'vendorStats');
        Route::get('/notification', 'notification');
        Route::post('/update-notification', 'updateNotificationStatus');
        Route::get('/reviews', 'vendorReviews');
    });

    Route::controller('OrderController')->group(function () {
        Route::get('/orders', 'listOrders');
        Route::get('/order/{order_item_id}', 'orderDetails');
        Route::post('/order/updateStatus', 'updateOrderStatus');
        Route::get('/listReturns', 'listReturns');
        Route::get('/returns/{return_id}', 'returnDetail');
    });
 
});
