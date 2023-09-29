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
        $this->app->bind('App\Http\Interfaces\Api\Setting\UserInterface','App\Http\Repositories\Api\Setting\UserRepository');
        $this->app->bind('App\Http\Interfaces\Api\Setting\RoleInterface','App\Http\Repositories\Api\Setting\RoleRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\BankAccountTypeInterface','App\Http\Repositories\Api\Master\BankAccountTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\BankInterface','App\Http\Repositories\Api\Master\BankRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\AddressTypeInterface','App\Http\Repositories\Api\CommonMaster\AddressTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\LanguageInterface','App\Http\Repositories\Api\CommonMaster\LanguageRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgAdministratorTypeInterface','App\Http\Repositories\Api\OrganizationMaster\OrgAdministratorTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessActivitiesInterface','App\Http\Repositories\Api\OrganizationMaster\OrgBusinessActivitiesRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSaleSubsetInterface','App\Http\Repositories\Api\OrganizationMaster\OrgBusinessSaleSubsetRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSectorInterface','App\Http\Repositories\Api\OrganizationMaster\OrgBusinessSectorRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgCategoryInterface','App\Http\Repositories\Api\OrganizationMaster\OrgCategoryRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgDocumentTypeInterface','App\Http\Repositories\Api\OrganizationMaster\OrgDocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgOwnerShipInterface','App\Http\Repositories\Api\OrganizationMaster\OrgOwnerShipRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrgStructureInterface','App\Http\Repositories\Api\OrganizationMaster\OrgStructureRepository');
        $this->app->bind('App\Http\Interfaces\Api\Master\DocumentTypeInterface','App\Http\Repositories\Api\Master\DocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\CountryInterface','App\Http\Repositories\Api\CommonMaster\CountryRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\StateInterface','App\Http\Repositories\Api\CommonMaster\StateRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\CityInterface','App\Http\Repositories\Api\CommonMaster\CityRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\DistrictInterface','App\Http\Repositories\Api\CommonMaster\DistrictRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\AreaInterface','App\Http\Repositories\Api\CommonMaster\AreaRepository');














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
