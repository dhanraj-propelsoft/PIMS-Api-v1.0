<?php

use App\Http\Controllers\Api\Master\SalutationController;
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

// Include API version 1 routes
include_once('Api/master.php');
include_once('Api/user.php');
include_once('Api/organizationMaster.php');
