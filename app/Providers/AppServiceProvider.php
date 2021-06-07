<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    
    public function __construct($app) {
        parent::__construct($app);
        $this->wheaterProvider = config('weather.provider');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
         $this->app->bind(\App\Weather\Interfaces\FrontendRepositoryInterface::class,function()
        {            
            return new \App\Weather\Repositories\FrontendRepository;
        });
        
        
         $this->app->bind(\App\Weather\Interfaces\CurrentWeatherRepositoryInterface::class,function()
        {    
             if( $this->wheaterProvider == "openweathermap.org")
                return new \App\Weather\Repositories\OpenWeatherCurrentWeatherRepository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
          if (env('APP_DEBUG')) {
            DB::listen(function($query) {
                File::append(
                        storage_path('/logs/query.log'), $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
                );
            });
        }
    }
}
