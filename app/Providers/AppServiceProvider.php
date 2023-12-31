<?php

namespace App\Providers;

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
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\salutationInterface', 'App\Http\Repositories\Api\PersonMaster\SalutationRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\GenderInterface', 'App\Http\Repositories\Api\PersonMaster\GenderRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\BloodGroupInterface', 'App\Http\Repositories\Api\PersonMaster\BloodGroupRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\MaritalStatusInterface', 'App\Http\Repositories\Api\PersonMaster\MaritalStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\RelationShipInterface', 'App\Http\Repositories\Api\PersonMaster\RelationShipRepository');
        $this->app->bind('App\Http\Interfaces\Api\Setting\UserInterface', 'App\Http\Repositories\Api\Setting\UserRepository');
        $this->app->bind('App\Http\Interfaces\Api\Setting\RoleInterface', 'App\Http\Repositories\Api\Setting\RoleRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\BankAccountTypeInterface', 'App\Http\Repositories\Api\PersonMaster\BankAccountTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\BankInterface', 'App\Http\Repositories\Api\PersonMaster\BankRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\AddressTypeInterface', 'App\Http\Repositories\Api\CommonMaster\AddressTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\LanguageInterface', 'App\Http\Repositories\Api\CommonMaster\LanguageRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\AdministratorTypeInterface', 'App\Http\Repositories\Api\OrganizationMaster\AdministratorTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\BusinessActivitiesInterface', 'App\Http\Repositories\Api\OrganizationMaster\BusinessActivitiesRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\BusinessSaleSubsetInterface', 'App\Http\Repositories\Api\OrganizationMaster\BusinessSaleSubsetRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\BusinessSectorInterface', 'App\Http\Repositories\Api\OrganizationMaster\BusinessSectorRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\CategoryInterface', 'App\Http\Repositories\Api\OrganizationMaster\CategoryRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\DocumentTypeInterface', 'App\Http\Repositories\Api\OrganizationMaster\DocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OwnerShipInterface', 'App\Http\Repositories\Api\OrganizationMaster\OwnerShipRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\StructureInterface', 'App\Http\Repositories\Api\OrganizationMaster\StructureRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\DocumentTypeInterface', 'App\Http\Repositories\Api\PersonMaster\DocumentTypeRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\CountryInterface', 'App\Http\Repositories\Api\CommonMaster\CountryRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\StateInterface', 'App\Http\Repositories\Api\CommonMaster\StateRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\CityInterface', 'App\Http\Repositories\Api\CommonMaster\CityRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\DistrictInterface', 'App\Http\Repositories\Api\CommonMaster\DistrictRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\AreaInterface', 'App\Http\Repositories\Api\CommonMaster\AreaRepository');
        $this->app->bind('App\Http\Interfaces\Api\CommonMaster\PackageInterface', 'App\Http\Repositories\Api\CommonMaster\PackageRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\ActiveStatusInterface', 'App\Http\Repositories\Api\PFM\ActiveStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\AuthorizationInterface', 'App\Http\Repositories\Api\PFM\AuthorizationRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\CachetInterface', 'App\Http\Repositories\Api\PFM\CachetRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\DeponeStatusInterface', 'App\Http\Repositories\Api\PFM\DeponeStatusRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\ExistenceInterface', 'App\Http\Repositories\Api\PFM\ExistenceRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\OriginInterface', 'App\Http\Repositories\Api\PFM\OriginRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\PersonStageInterface', 'App\Http\Repositories\Api\PFM\PersonStageRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\SurvivalInterface', 'App\Http\Repositories\Api\PFM\SurvivalRepository');
        $this->app->bind('App\Http\Interfaces\Api\PFM\ValidationInterface', 'App\Http\Repositories\Api\PFM\ValidationRepository');
        $this->app->bind('App\Http\Interfaces\Api\PersonMaster\QualificationInterface', 'App\Http\Repositories\Api\PersonMaster\QualificationRepository');
        $this->app->bind('App\Http\Interfaces\Api\OrganizationMaster\OrganizationInterface', 'App\Http\Repositories\Api\OrganizationMaster\OrganizationRepository');

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
