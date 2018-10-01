<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->validator->extendImplicit('array_not_null', function ($attribute, $value, $parameters) {
            $hasEmptyElement = ['one-element'];

            if(count($value) > 0){
                $hasEmptyElement = array_filter($value, function($val){
                    return($val == "");
                });
            }

            return count($hasEmptyElement) == 0;

        }, 'Debes seleccionar :attribute');

        $this->app->validator->extendImplicit('array_object_not_null', function ($attribute, $value, $parameters) {
            $hasEmptyElement = ['one-element'];
            $collector = [];
 
            if(count($value) > 0){

                for($i = 0; $i < count($parameters); $i++){
                    $name = $parameters[$i];
                    
                    $hasEmptyElement = array_filter($value, function($val) use ($name){
                        return($val[$name] == "");
                    });
                    
                    if(count($hasEmptyElement) > 0){
                        $collector[] = $hasEmptyElement;
                    }
                }
            }

            return count($collector) == 0;

        }, 'Debes seleccionar / ingresar :attribute');
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
