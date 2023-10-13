<?php

use App\Http\Controllers\Api\PFM\ActiveStatusController;
use App\Http\Controllers\Api\PFM\AuthorizationController;
use App\Http\Controllers\Api\PFM\CachetController;
use App\Http\Controllers\Api\PFM\DeponeStatusController;
use App\Http\Controllers\Api\PFM\ExistenceController;
use App\Http\Controllers\Api\PFM\OriginController;
use App\Http\Controllers\Api\PFM\PersonStageController;
use App\Http\Controllers\Api\PFM\SurvivalController;
use App\Http\Controllers\Api\PFM\ValidationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('activeStatus',ActiveStatusController::class);
Route::apiResource('authorization',AuthorizationController::class);
Route::apiResource('cachet',CachetController::class);
Route::apiResource('deponeStatus',DeponeStatusController::class);
Route::apiResource('existence',ExistenceController::class);
Route::apiResource('origin',OriginController::class);
Route::apiResource('personStage',PersonStageController::class);
Route::apiResource('survival',SurvivalController::class);
Route::apiResource('validation',ValidationController::class);
Route::post('originValidation', [OriginController::class, 'validation']);
Route::post('authorizationValidation', [AuthorizationController::class, 'validation']);
Route::post('cachetValidation', [CachetController::class, 'validation']);
Route::post('deponeStatusValidation', [DeponeStatusController::class, 'validation']);
Route::post('existenceValidation', [ExistenceController::class, 'validation']);
Route::post('personStageValidation', [PersonStageController::class, 'validation']);
Route::post('survivalValidation', [SurvivalController::class, 'validation']);
Route::post('validationChecking', [ValidationController::class, 'validation']);
