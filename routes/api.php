<?php

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
Route::post('userAccess', 'App\Http\Controllers\Api\Setting\UserController@userAccess')->name('userAccess');

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    include_once ('Api/master.php');
    include_once ('Api/setting.php');
    include_once ('Api/organizationMaster.php');
    include_once ('Api/commonMaster.php');

    });
    // Your routes here, which will only be accessible to authenticated users
    
// Include API version 1 routes
