<?php

namespace App\Providers;

use App\Represent\Represent;
use App\Represent\Rules\AllowedToApply;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('allowed2apply', function ($attribute, $value, $parameters, $validator) {

                // join one to one
                if (count($parameters) == 2 and preg_match('/^\@/', $parameters[0])) {
                    return Represent::from($parameters[0])
                        ->exists($parameters[1]);

                // join through pivot table
                } else if (count($parameters) >= 1 and preg_match('/^\[\]/', $parameters[0])) {
                     return Represent::from($parameters[0])
                         ->exists(array_slice($parameters,1));
                }

                return false;



            }, "Can not find selected :attribute"
        );

        Validator::extend('editable', function ($attribute, $value, $parameters, $validator) {
                return isset($parameters[0]) and $parameters[0] == '1';
            }, "You not allowed change :attribute"
        );
    }
}
