<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\api_model;
use App\login_model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('ns_unique', function($attribute, $value, $parameters) {
            return api_model::check_device_id($value,$parameters);
        });

        //check the old password by token
        Validator::extend('ns_exits_by_token', function($attribute, $value, $parameters) {
            return login_model::check_password_by_token2($value,$parameters);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
