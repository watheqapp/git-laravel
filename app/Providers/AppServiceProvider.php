<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);

        Validator::extend('saudi_phone', function($attribute, $value, $parameters) {
            ///^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/
            return preg_match('/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $value);
        });
        
        Validator::extend('password_validate', function($attribute, $value, $parameters)
        {
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $value);
        });

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
