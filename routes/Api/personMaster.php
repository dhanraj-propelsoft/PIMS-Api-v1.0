<?php

use App\Http\Controllers\Api\PersonMaster\SalutationController;
use App\Http\Controllers\Api\PersonMaster\GenderController;
use App\Http\Controllers\Api\PersonMaster\BloodGroupController;
use App\Http\Controllers\Api\PersonMaster\MaritalStatusController;
use App\Http\Controllers\Api\PersonMaster\RelationShipController;
use App\Http\Controllers\Api\PersonMaster\BankAccountTypeController;
use App\Http\Controllers\Api\PersonMaster\BankController;
use App\Http\Controllers\Api\PersonMaster\CommonAddressTypeController;
use App\Http\Controllers\Api\PersonMaster\CommonLanguageController;
use App\Http\Controllers\Api\PersonMaster\DocumentTypeController;
use App\Http\Controllers\Api\PersonMaster\CommonCountryController;
use App\Http\Controllers\Api\PersonMaster\CommonStateController;
use App\Http\Controllers\Api\PersonMaster\CommonCityController;
use App\Http\Controllers\Api\PersonMaster\QualificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('salutation', SalutationController::class);
Route::apiResource('gender', GenderController::class);
Route::apiResource('bank', BankController::class);
Route::apiResource('bloodGroup', BloodGroupController::class);
Route::apiResource('maritalStatus', MaritalStatusController::class);
Route::apiResource('relationShip', RelationShipController::class);
Route::apiResource('bankAccountType', BankAccountTypeController::class);
Route::apiResource('documentType', DocumentTypeController::class);
Route::apiResource('qualification', QualificationController::class);




