<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register')->name('register');
    Route::post('customer/create', 'Api\CustomerController@CustomerCreate');

    Route::middleware(['auth:api'])->group(function () {

    });
});
