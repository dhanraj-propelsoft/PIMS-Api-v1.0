<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\Users\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    public function userLogin(Request $request)
    {
        Log::info('UserController > login function Inside.' . json_encode($request->all()));
        $response = $this->UserService->userLogin($request->all());
        Log::info('UserController > login function Return.' . json_encode($response));
        return $response;
    }
    public function userRegister(Request $request)
    {
        Log::info('UserController > login function Inside.' . json_encode($request->all()));
        $response = $this->UserService->userRegister($request->all());
        Log::info('UserController > login function Return.' . json_encode($response));
        return $response;
    }
}
