<?php

// use App\Http\Controllers\Api\Master\BankAccountTypeController;
// use App\Http\Controllers\Api\Master\BankController;
// use App\Http\Controllers\Api\Master\CommonLanguageController;
use App\Http\Controllers\Api\CommonMaster\CountryController;
use App\Http\Controllers\Api\CommonMaster\StateController;
use App\Http\Controllers\Api\CommonMaster\CityController;
use App\Http\Controllers\Api\CommonMaster\AddressTypeController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

  Route::apiResource('country', CountryController::class);
  Route::apiResource('state',  StateController::class);
  Route::apiResource('city', CityController::class);
  Route::apiResource('addressType',AddressTypeController::class);
// Route::apiResource('commonLanguage', CommonLanguageController::class);
