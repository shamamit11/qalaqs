<?php

use Illuminate\Http\Request;
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

Route::get('/banner', 'BannerController@list');
Route::controller('ProductController')->group(function () {
    Route::get('/make', 'make');
    Route::get('/model', 'model');
    Route::get('/year', 'year');
    Route::get('/engine', 'engine');
    Route::get('/category', 'category');
    Route::get('/subcategory', 'subcategory');
    Route::get('/product', 'product');
});



