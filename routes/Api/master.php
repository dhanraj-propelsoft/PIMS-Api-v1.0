<?php

use App\Http\Controllers\Api\Master\SalutationController;
use App\Http\Controllers\Api\Master\GenderController;
use App\Http\Controllers\Api\Master\BloodGroupController;
use App\Http\Controllers\Api\Master\MaritalStatusController;
use App\Http\Controllers\Api\Master\RelationShipController;
use App\Http\Controllers\Api\Master\BankAccountTypeController;
use App\Http\Controllers\Api\Master\BankController;
use App\Http\Controllers\Api\Master\CommonAddressTypeController;
use App\Http\Controllers\Api\Master\CommonLanguageController;
use App\Http\Controllers\Api\Master\DocumentTypeController;
use App\Http\Controllers\Api\Master\CommonCountryController;
use App\Http\Controllers\Api\Master\CommonStateController;
use App\Http\Controllers\Api\Master\CommonCityController;
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




