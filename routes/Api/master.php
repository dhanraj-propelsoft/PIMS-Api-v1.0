<?php

use App\Http\Controllers\Api\Master\SalutationController;
use App\Http\Controllers\Api\Master\GenderController;
use App\Http\Controllers\Api\Master\BloodGroupController;
use App\Http\Controllers\Api\Master\MaritalStatusController;
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
Route::apiResource('bloodGroup', BloodGroupController::class);
Route::apiResource('maritalStatus', MaritalStatusController::class);