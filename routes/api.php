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
        Route::get('laywer/prices', 'Api\CategoryController@listLawyerPrices');

        // Laywer
        Route::post('lawyer/completeProfile', 'Api\LawyerController@completeProfile');
        Route::post('lawyer/completeFiles', 'Api\LawyerController@completeFiles');
        Route::post('lawyer/updateVisibility', 'Api\LawyerController@updateVisibility');
        Route::post('lawyer/updateProfile', 'Api\LawyerController@updateProfile');
        Route::post('lawyer/registerDeviceToken', 'Api\LawyerController@registerDevice');
        Route::post('lawyer/logout', 'Api\LawyerController@logout');
        
        // Order
        Route::post('order', 'Api\OrderController@order');
        Route::get('orderDetails', 'Api\LawyerOrderController@orderDetails');
        Route::get('order/laywersList', 'Api\OrderController@listOrderLawyers');
        
        // Client-Order
        Route::get('client/order/selectLaywer', 'Api\ClientOrderController@selectOrderLawyer');
        Route::get('client/order/listNewOrders', 'Api\ClientOrderController@listNewOrders');
        Route::get('client/order/listPendingOrders', 'Api\ClientOrderController@listPendingOrders');
        Route::get('client/order/listClosedOrders', 'Api\ClientOrderController@listClosedOrders');
        Route::get('client/order/listRemovedOrders', 'Api\ClientOrderController@listRemovedOrders');
        Route::post('client/order/rate', 'Api\ClientOrderController@rateOrder');
        Route::get('client/order/moveToSupport', 'Api\ClientOrderController@moveOrderToSupport');
        Route::get('client/order/remove', 'Api\ClientOrderController@removeOrder');

        // Laywer-Order
        Route::get('lawyer/order/accept', 'Api\LawyerOrderController@acceptOrder');
        Route::get('lawyer/order/close', 'Api\LawyerOrderController@closeOrder');
        Route::get('lawyer/order/listPendingOrders', 'Api\LawyerOrderController@listPendingOrders');
        Route::get('lawyer/order/listClosedOrders', 'Api\LawyerOrderController@listClosedOrders');
        Route::get('lawyer/order/listRemovedOrders', 'Api\LawyerOrderController@listRemovedOrders');
        Route::get('lawyer/order/remove', 'Api\LawyerOrderController@removeOrder');

        // General
        Route::post('contactus/create', 'Api\ApiBaseController@contactUs');
        Route::get('social/links', 'Api\ApiBaseController@socialLinks');
        Route::get('notification/list', 'Api\ApiBaseController@listNotifications');
        
        
    });
});
