<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Setting\UserController;
use App\Http\Controllers\Api\Setting\RoleController;



Route::get('getRoleMaster', 'App\Http\Controllers\Api\Setting\RoleController@getRoleMaster')->name('getRoleMaster');
Route::post('userAccess', 'App\Http\Controllers\Api\Setting\UserController@userAccess')->name('userAccess');
Route::apiResource('roles', RoleController::class);
Route::apiResource('user', UserController::class);




