<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\Setting\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->userService->index();
        Log::info('UserController > index  function Return.' . json_encode($response));
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('UserController > Store  function Return.' . json_encode($request->all()));
        $response = $this->userService->store($request->all());
        Log::info('UserController > Store  function Return.' . json_encode($response));
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('UserController > show  function Return.' . json_encode($id));
        $response = $this->userService->getUserById($id);
        Log::info('UserController > show  function Return.' . json_encode($response));
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('UserController-> destroy Inside.' . json_encode($id));
        $response = $this->userService->destroyUserById($id);
        return $response;
        Log::info('UserController ->destroy Return.' . json_encode($response));
    }
    public function userAccess(Request $request)
    {
        Log::info('UserController > userAccess function Inside.' . json_encode($request->all()));
        $response = $this->userService->userAccess($request->all());
        Log::info('UserController > userAccess function Return.' . json_encode($response));
        return $response;
    }
}
