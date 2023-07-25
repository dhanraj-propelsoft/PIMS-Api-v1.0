<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationMaster\OrgAdministratorTypeController;
use App\Http\Controllers\Api\OrganizationMaster\OrgBusinessActivitiesController;
use App\Http\Controllers\Api\OrganizationMaster\OrgBusinessSaleSubsetController;
use App\Http\Controllers\Api\OrganizationMaster\OrgBusinessSectorController;
use App\Http\Controllers\Api\OrganizationMaster\OrgCategoryController;
use App\Http\Controllers\Api\OrganizationMaster\OrgDocumentTypeController;
use App\Http\Controllers\Api\OrganizationMaster\OrgOwnerShipController;





Route::apiResource('orgAdministratorType',OrgAdministratorTypeController::class);
Route::apiResource('orgBusinessActivities',OrgBusinessActivitiesController::class);
Route::apiResource('orgBusinessSaleSubset',OrgBusinessSaleSubsetController::class);
Route::apiResource('orgBusinessSector',OrgBusinessSectorController::class);
Route::apiResource('orgCategory',OrgCategoryController::class);
Route::apiResource('orgDocumentType',OrgDocumentTypeController::class);
Route::apiResource('orgOwnerShip',OrgOwnerShipController::class);