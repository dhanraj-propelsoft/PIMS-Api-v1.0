<?php


use App\Http\Controllers\Api\CommonMaster\AddressTypeController;
use App\Http\Controllers\Api\CommonMaster\AreaController;
use App\Http\Controllers\Api\CommonMaster\CityController;
use App\Http\Controllers\Api\CommonMaster\CountryController;
use App\Http\Controllers\Api\CommonMaster\DistrictController;
use App\Http\Controllers\Api\CommonMaster\LanguageController;
use App\Http\Controllers\Api\CommonMaster\StateController;
use App\Http\Controllers\Api\CommonMaster\PackageController;
use Illuminate\Support\Facades\Route;

Route::apiResource('country', CountryController::class);
Route::apiResource('state', StateController::class);
Route::apiResource('city', CityController::class);
Route::apiResource('addressType', AddressTypeController::class);
Route::apiResource('language', LanguageController::class);
Route::apiResource('district', DistrictController::class);
Route::apiResource('area', AreaController::class);
Route::apiResource('package', PackageController::class);
Route::post('/countryValidation', [CountryController::class, 'validation'])->name('validation');
Route::post('/stateValidation', [StateController::class, 'stateValidation'])->name('stateValidation');
Route::post('/cityValidation', [CityController::class, 'cityValidation'])->name('cityValidation');
Route::post('/districtValidation', [DistrictController::class, 'districtValidation'])->name('districtValidation');
Route::post('/areaValidation', [AreaController::class, 'areaValidation'])->name('areaValidation');
Route::post('/addressTypeValidation', [AddressTypeController::class, 'addressTypeValidation'])->name('addressTypeValidation');
Route::post('/languageValidation', [LanguageController::class, 'languageValidation'])->name('languageValidation');
Route::post('/packageValidation', [PackageController::class, 'packageValidation'])->name('packageValidation');

Route::post('/getStateByCountryId', [StateController::class, 'getStateByCountryId'])->name('getStateByCountryId');
Route::post('/getDistrictByStateId', [DistrictController::class, 'getDistrictByStateId'])->name('getDistrictByStateId');
Route::post('/getCityByDistrictId', [CityController::class, 'getCityByDistrictId'])->name('getCityByDistrictId');
Route::post('/getAreaByCityId', [AreaController::class, 'getAreaByCityId'])->name('getAreaByCityId');
