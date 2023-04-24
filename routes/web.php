<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/vendor/verify-account/{token}', 'CommonController@verifyVendorAccount')->name('verify-account-vendor');
Route::get('/user/verify-account/{token}', 'CommonController@verifyUserAccount')->name('verify-account-user');
Route::get('/account-verified', 'CommonController@accountVerified')->name('account-verified');
Route::get('/account-not-verified', 'CommonController@accountNotVerified')->name('account-not-verified');
