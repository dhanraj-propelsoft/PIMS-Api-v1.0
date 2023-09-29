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
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\salutationInterface','App\Http\Repositories\Api\PersonMaster\SalutationRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\GenderInterface','App\Http\Repositories\Api\PersonMaster\GenderRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\BloodGroupInterface','App\Http\Repositories\Api\PersonMaster\BloodGroupRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\MaritalStatusInterface','App\Http\Repositories\Api\PersonMaster\MaritalStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\RelationShipInterface','App\Http\Repositories\Api\PersonMaster\RelationShipRepository');
        $this->app->bind('App\Http\Interfaces\Api\Setting\UserInterface','App\Http\Repositories\Api\Setting\UserRepository');
        $this->app->bind('App\Http\Interfaces\Api\Setting\RoleInterface','App\Http\Repositories\Api\Setting\RoleRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\BankAccountTypeInterface','App\Http\Repositories\Api\PersonMaster\BankAccountTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\BankInterface','App\Http\Repositories\Api\PersonMaster\BankRepository');
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
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\DocumentTypeInterface','App\Http\Repositories\Api\PersonMaster\DocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\CountryInterface','App\Http\Repositories\Api\CommonMaster\CountryRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\StateInterface','App\Http\Repositories\Api\CommonMaster\StateRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\CityInterface','App\Http\Repositories\Api\CommonMaster\CityRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\DistrictInterface','App\Http\Repositories\Api\CommonMaster\DistrictRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\AreaInterface','App\Http\Repositories\Api\CommonMaster\AreaRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\ActiveStatusInterface','App\Http\Repositories\Api\PFM\ActiveStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\AuthorizationInterface','App\Http\Repositories\Api\PFM\AuthorizationRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\CachetInterface','App\Http\Repositories\Api\PFM\CachetRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\DeponeStatusInterface','App\Http\Repositories\Api\PFM\DeponeStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\ExistenceInterface','App\Http\Repositories\Api\PFM\ExistenceRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\OriginInterface','App\Http\Repositories\Api\PFM\OriginRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\PersonStageInterface','App\Http\Repositories\Api\PFM\PersonStageRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\SurvivalInterface','App\Http\Repositories\Api\PFM\SurvivalRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\ValidationInterface','App\Http\Repositories\Api\PFM\ValidationRepository');














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
