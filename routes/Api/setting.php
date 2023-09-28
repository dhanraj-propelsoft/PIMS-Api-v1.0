<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Setting\UserController;
use App\Http\Controllers\Api\Setting\RoleController;



Route::get('getRoleMaster', 'App\Http\Controllers\Api\Setting\RoleController@getRoleMaster')->name('getRoleMaster');
Route::apiResource('roles', RoleController::class);
Route::apiResource('user', UserController::class);




