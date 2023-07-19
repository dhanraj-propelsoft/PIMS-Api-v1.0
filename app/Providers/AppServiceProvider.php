<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\Interfaces\Api\Master\salutationInterface','App\Http\Repositories\Api\Master\SalutationRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\GenderInterface','App\Http\Repositories\Api\Master\GenderRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\BloodGroupInterface','App\Http\Repositories\Api\Master\BloodGroupRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\MaritalStatusInterface','App\Http\Repositories\Api\Master\MaritalStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\RelationShipInterface','App\Http\Repositories\Api\Master\RelationShipRepository');



    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
