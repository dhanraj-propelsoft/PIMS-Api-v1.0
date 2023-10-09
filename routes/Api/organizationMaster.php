<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationMaster\AdministratorTypeController;
use App\Http\Controllers\Api\OrganizationMaster\BusinessActivitiesController;
use App\Http\Controllers\Api\OrganizationMaster\BusinessSaleSubsetController;
use App\Http\Controllers\Api\OrganizationMaster\BusinessSectorController;
use App\Http\Controllers\Api\OrganizationMaster\CategoryController;
use App\Http\Controllers\Api\OrganizationMaster\DocumentTypeController;
use App\Http\Controllers\Api\OrganizationMaster\OwnerShipController;
use App\Http\Controllers\Api\OrganizationMaster\StructureController;
use App\Http\Controllers\Api\OrganizationMaster\OrganizationController;



Route::apiResource('administratorType',AdministratorTypeController::class);
Route::apiResource('businessActivities',BusinessActivitiesController::class);
Route::apiResource('businessSaleSubset',BusinessSaleSubsetController::class);
Route::apiResource('businessSector',BusinessSectorController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('orgDocumentType',DocumentTypeController::class);
Route::apiResource('ownerShip',OwnerShipController::class);
Route::apiResource('structure',StructureController::class);
Route::get('tempOrganizationList', [OrganizationController::class, 'tempOrganizationList'])->name('tempOrganizationList');

