<?php

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

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */
//Auth::routes();
// Authentication Routes...

//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('order/log', 'HomeController@orderLog');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'backend', 'middleware' => ['auth', 'backendUser']], function() {
    Route::get('/', 'Backend\\BackendController@index')->name('backend.home');
    
    // Profile
    Route::get('profile', 'Backend\UsersController@profile')->name('backend.profile.edit');
    Route::post('profile/update/{id}', 'Backend\UsersController@profileUpdate')->name('backend.profile.update');
    
    // Users
    Route::get('/employee/list', 'Backend\EmployeeController@index')->name('backend.employee.index')->middleware(['permission:role-employee']);
    Route::get('/employee/list-data', 'Backend\EmployeeController@listData')->name('backend.employee.listAjax')->middleware(['permission:role-employee']);
    Route::get('/employee/create', 'Backend\EmployeeController@create')->name('backend.employee.create')->middleware(['permission:role-employee']);
    Route::post('/employee/store', 'Backend\EmployeeController@store')->name('backend.employee.add')->middleware(['permission:role-employee']);
    Route::get('/employee/edit/{id}', 'Backend\EmployeeController@edit')->name('backend.employee.edit')->middleware(['permission:role-employee']);
    Route::post('/employee/update/{id}', 'Backend\EmployeeController@update')->name('backend.employee.update')->middleware(['permission:role-employee']);
    Route::get('/employee/delete/{id}', 'Backend\EmployeeController@destroy')->name('backend.employee.delete')->middleware(['permission:role-employee']);
    Route::get('/employee/toggleActive/{id}/{active}', 'Backend\EmployeeController@toggleActive')->name('backend.employee.toggleActive')->middleware(['permission:role-employee']);
    Route::get('/user/change-password', 'Backend\\userController@changePasswordForm')->name('user.change_password.form');
    Route::post('/user/change-password', 'Backend\\userController@changePassword')->name('user.change_password.action');
    
    
    // Client
    Route::get('/client/list', 'Backend\ClientController@index')->name('backend.client.index')->middleware(['permission:role-client']);
    Route::get('/client/list-data', 'Backend\ClientController@listData')->name('backend.client.listAjax')->middleware(['permission:role-client']);
    Route::get('/client/edit/{id}', 'Backend\ClientController@edit')->name('backend.client.edit')->middleware(['permission:role-client']);
    Route::post('/client/update/{id}', 'Backend\ClientController@update')->name('backend.client.update')->middleware(['permission:role-client']);
    Route::get('/client/delete/{id}', 'Backend\ClientController@destroy')->name('backend.client.delete')->middleware(['permission:role-client']);
    Route::get('/client/toggleActive/{id}/{active}', 'Backend\ClientController@toggleActive')->name('backend.client.toggleActive')->middleware(['permission:role-client']);
    Route::get('client/map', 'Backend\ClientController@clientsMap')->name('backend.client.map');

    // Client
    Route::get('/lawyer/laywers-list', 'Backend\LawyerController@LawyersList')->name('backend.lawyer.index')->middleware(['permission:role-lawyer']);
    Route::get('/lawyer/lawyers-list-data', 'Backend\LawyerController@listLawyerData')->name('backend.lawyer.listAjax')->middleware(['permission:role-lawyer']);
    Route::get('/lawyer/authorized-list', 'Backend\LawyerController@authorizedList')->name('backend.authorized.index')->middleware(['permission:role-lawyer']);
    Route::get('/lawyer/authorized-list-data', 'Backend\LawyerController@listAuthorizedData')->name('backend.authorized.listAjax')->middleware(['permission:role-lawyer']);


    Route::get('/lawyer/show/{id}', 'Backend\LawyerController@show')->name('backend.lawyer.show')->middleware(['permission:role-lawyer']);
    Route::get('/lawyer/edit/{id}', 'Backend\LawyerController@edit')->name('backend.lawyer.edit')->middleware(['permission:role-lawyer']);
    Route::post('/lawyer/update/{id}', 'Backend\LawyerController@update')->name('backend.lawyer.update')->middleware(['permission:role-lawyer']);
    Route::get('/lawyer/delete/{id}', 'Backend\LawyerController@destroy')->name('backend.lawyer.delete')->middleware(['permission:role-lawyer']);
    Route::get('/lawyer/toggleActive/{id}/{active}', 'Backend\LawyerController@toggleActive')->name('backend.lawyer.toggleActive')->middleware(['permission:role-lawyer']);
    Route::get('lawyer/map', 'Backend\LawyerController@clientsMap')->name('backend.lawyer.map');

    //roles
    Route::get('/role/list', 'Backend\RoleController@index')->name('backend.role.index')->middleware(['permission:role-role']);
    Route::get('/role/list-data', 'Backend\RoleController@listData')->name('backend.role.listAjax');
    Route::get('role/create', 'Backend\RoleController@create')->name('backend.role.create')->middleware(['permission:role-role']);
    Route::post('role/store', 'Backend\RoleController@store')->name('backend.role.store')->middleware(['permission:role-role']);
    Route::get('role/edit/{id}', 'Backend\RoleController@edit')->name('backend.role.edit')->middleware(['permission:role-role']);
    Route::post('role/update/{id}', 'Backend\RoleController@update')->name('backend.role.update')->middleware(['permission:role-role']);
    Route::get('role/{id}', 'Backend\RoleController@destroy')->name('backend.role.delete')->middleware(['permission:role-role']);

    
    // static pages
    $this->get('/pages/edit', 'Backend\PagesController@edit')->name('backend.pages.edit')->middleware(['permission:role-setting-pages']);
    $this->post('/pages/update', 'Backend\PagesController@update')->name('backend.pages.update')->middleware(['permission:role-setting-pages']);
    
    // Prices setting
    $this->get('/price/edit', 'Backend\PricesController@edit')->name('backend.price.edit')->middleware(['permission:role-setting-prices']);
    $this->post('/price/update', 'Backend\PricesController@update')->name('backend.price.update')->middleware(['permission:role-setting-prices']);
    
    
    // Social setting
    $this->get('/social/edit', 'Backend\SocialController@edit')->name('backend.social.edit')->middleware(['permission:role-setting-social']);
    $this->post('/social/update', 'Backend\SocialController@update')->name('backend.social.update')->middleware(['permission:role-setting-social']);
    
    // Order
    Route::get('/order/list-new', 'Backend\OrderController@newOrders')->name('backend.order.new')->middleware(['permission:role-order']);
    Route::get('/order/list-new-data', 'Backend\OrderController@newOrdersData')->name('backend.order.newAjax')->middleware(['permission:role-order']);
    Route::get('/order/list-pending', 'Backend\OrderController@pendingOrders')->name('backend.order.pending')->middleware(['permission:role-order']);
    Route::get('/order/list-pending-data', 'Backend\OrderController@PendingOrdersData')->name('backend.order.pendingAjax')->middleware(['permission:role-order']);
    Route::get('/order/list-closed', 'Backend\OrderController@closedOrders')->name('backend.order.closed')->middleware(['permission:role-order']);
    Route::get('/order/list-closed-data', 'Backend\OrderController@closedOrdersData')->name('backend.order.closedAjax')->middleware(['permission:role-order']);
    Route::get('/order/list-removed', 'Backend\OrderController@removedOrders')->name('backend.order.removed')->middleware(['permission:role-order']);
    Route::get('/order/list-removed-data', 'Backend\OrderController@removedOrdersData')->name('backend.order.removedAjax')->middleware(['permission:role-order']);
    Route::get('/order/list-support', 'Backend\OrderController@supportOrders')->name('backend.order.support')->middleware(['permission:role-order']);
    Route::get('/order/list-support-data', 'Backend\OrderController@supportOrdersData')->name('backend.order.supportAjax')->middleware(['permission:role-order']);
    Route::get('/order/show/{id}', 'Backend\OrderController@show')->name('backend.order.show')->middleware(['permission:role-order']);
    Route::get('/order/delete/{id}', 'Backend\OrderController@destroy')->name('backend.order.delete')->middleware(['permission:role-order']);
    Route::get('/order/assignLawyer/{id}', 'Backend\OrderController@assignLawyerModel')->name('backend.order.assignLawyerModal')->middleware(['permission:role-order']);
    Route::post('/order/assignLawyer', 'Backend\OrderController@assignLawyer')->name('backend.order.assignLawyer')->middleware(['permission:role-order']);
    Route::get('order/map', 'Backend\OrderController@ordersMap')->name('backend.order.map');

    // Client Contact messages
    Route::get('/clientContact/list', 'Backend\ClientContactController@index')->name('backend.clientContact.index')->middleware(['permission:role-clientContact']);
    Route::get('/clientContact/list-data', 'Backend\ClientContactController@listData')->name('backend.clientContact.listAjax')->middleware(['permission:role-clientContact']);

    // Lawyer Contact messages
    Route::get('/lawyerContact/list', 'Backend\LawyerContactController@index')->name('backend.lawyerContact.index')->middleware(['permission:role-lawyerContact']);
    Route::get('/lawyerContact/list-data', 'Backend\LawyerContactController@listData')->name('backend.lawyerContact.listAjax')->middleware(['permission:role-lawyerContact']);


    // Lawyer Contact messages
    Route::get('/notification/list', 'Backend\LawyerContactController@index')->name('backend.lawyerContact.index')->middleware(['permission:role-lawyerContact']);
    Route::get('/lawyerContact/list-data', 'Backend\LawyerContactController@listData')->name('backend.lawyerContact.listAjax')->middleware(['permission:role-lawyerContact']);

    // Admin notifications messages
    Route::get('/notification/list', 'Backend\NotificationController@index')->name('backend.notification.index');
    Route::get('/notification/list-data', 'Backend\NotificationController@listData')->name('backend.notification.listAjax');
    Route::get('/notification/read', 'Backend\NotificationController@read')->name('backend.notification.read');


});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/terms', 'HomeController@terms')->name('frontend.terms');
Route::get('/policy', 'HomeController@help')->name('frontend.policy');
Route::get('/questions', 'HomeController@questions')->name('frontend.questions');
