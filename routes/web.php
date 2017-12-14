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
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('order/log', 'HomeController@orderLog');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'backend', 'middleware' => ['auth', 'backendUser']], function() {
    $this->get('/', 'Backend\\BackendController@index')->name('backend.home');
    
    Route::get('/user/change-password', 'Backend\\userController@changePasswordForm')->name('user.change_password.form');
    Route::post('/user/change-password', 'Backend\\userController@changePassword')->name('user.change_password.action');
    

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
