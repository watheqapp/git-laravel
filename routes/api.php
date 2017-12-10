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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['CheckApiAuth']], function() {
    // Client
    Route::post('client/login', 'Api\ClientController@login');
    
    // Laywer
    Route::post('lawyer/login', 'Api\LawyerController@login');
    
    Route::group(['prefix' => 'auth', 'middleware' => 'jwt.auth'], function() {
        
        // Cient
        Route::post('client/completeProfile', 'Api\ClientController@completeProfile');
        Route::post('client/updateProfile', 'Api\ClientController@updateProfile');
        Route::post('client/registerDeviceToken', 'Api\ClientController@registerDevice');
        Route::post('client/logout', 'Api\ClientController@logout');
        
        // Category
        Route::get('category/list', 'Api\CategoryController@listCategories');

        // Laywer
        Route::post('lawyer/completeProfile', 'Api\LawyerController@completeProfile');
        Route::post('lawyer/completeFiles', 'Api\LawyerController@completeFiles');
        Route::post('lawyer/updateProfile', 'Api\LawyerController@updateProfile');
        Route::post('lawyer/registerDeviceToken', 'Api\LawyerController@registerDevice');
        Route::post('lawyer/logout', 'Api\LawyerController@logout');
        
        // Order
        Route::post('order', 'Api\OrderController@order');
        Route::get('orderDetails', 'Api\LawyerOrderController@orderDetails');
        Route::get('order/laywersList', 'Api\OrderController@listOrderLawyers');
        
        // Client-Order
        Route::get('client/order/selectLaywer', 'Api\ClientOrderController@selectOrderLawyer');
        
        // Laywer-Order
        Route::get('lawyer/order/accept', 'Api\LawyerOrderController@acceptOrder');
        
        
        
    });
});
