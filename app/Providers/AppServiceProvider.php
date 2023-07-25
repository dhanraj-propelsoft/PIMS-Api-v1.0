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
        $this->app->bind('App\Http\Interfaces\Api\Users\UserInterface','App\Http\Repositories\Api\Users\UserRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\BankAccountTypeInterface','App\Http\Repositories\Api\Master\BankAccountTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\BankInterface','App\Http\Repositories\Api\Master\BankRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\CommonAddressTypeInterface','App\Http\Repositories\Api\Master\CommonAddressTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\CommonLanguageInterface','App\Http\Repositories\Api\Master\CommonLanguageRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgAdministratorTypeInterface','App\Http\Repositories\Api\OrganizationMaster\OrgAdministratorTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessActivitiesInterface','App\Http\Repositories\Api\OrganizationMaster\OrgBusinessActivitiesRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSaleSubsetInterface','App\Http\Repositories\Api\OrganizationMaster\OrgBusinessSaleSubsetRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSectorInterface','App\Http\Repositories\Api\OrganizationMaster\OrgBusinessSectorRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgCategoryInterface','App\Http\Repositories\Api\OrganizationMaster\OrgCategoryRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgDocumentTypeInterface','App\Http\Repositories\Api\OrganizationMaster\OrgDocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgOwnerShipInterface','App\Http\Repositories\Api\OrganizationMaster\OrgOwnerShipRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\DocumentTypeInterface','App\Http\Repositories\Api\Master\DocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\CommonCountryInterface','App\Http\Repositories\Api\Master\CommonCountryRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\CommonStateInterface','App\Http\Repositories\Api\Master\CommonStateRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\CommonCityInterface','App\Http\Repositories\Api\Master\CommonCityRepository');







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
