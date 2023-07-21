<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users\UserController;

Route::post('userLogin', 'App\Http\Controllers\Api\Users\UserController@userLogin')->name('userLogin');
Route::post('userRegister', 'App\Http\Controllers\Api\Users\UserController@userRegister')->name('userRegister');
