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
        
        Route::get('category/list', 'Api\CategoryController@listCategories');


        // Laywer
        Route::post('lawyer/completeProfile', 'Api\LawyerController@completeProfile');
        Route::post('lawyer/completeFiles', 'Api\LawyerController@completeLawerFiles');
        Route::post('lawyer/updateProfile', 'Api\LawyerController@updateProfile');
        Route::post('lawyer/registerDeviceToken', 'Api\LawyerController@registerDevice');
        Route::post('lawyer/logout', 'Api\LawyerController@logout');
        

    });
});
