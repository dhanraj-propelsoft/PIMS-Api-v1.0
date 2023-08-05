<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Services\Api\Setting\RoleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $RoleService;
    public function __construct(RoleService $RoleService)
    {
        $this->RoleService = $RoleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->RoleService->index();
        Log::info('RoleController >  function Return.' . json_encode($response));
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
        Log::info('RoleController >  function Return.' . json_encode($request->all()));
        $response = $this->RoleService->store($request->all());
        Log::info('RoleController >  function Return.' . json_encode($response));
        return $response;
    }
    public function getRoleMaster()
    {
        $response = $this->RoleService->getRoleMaster();
        Log::info('RoleController > getRoleMaster  function Return.' . json_encode($response));
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
        Log::info('RoleController >  show function Return.' . json_encode($id));
        $response = $this->RoleService->getRoleAllDetails($id);
        Log::info('RoleController >  show function Return.' . json_encode($response));
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
        Log::info('RoleController >  destroy function Return.' . json_encode($id));
        $response = $this->RoleService->destoryRoleById($id);
        Log::info('RoleController >  destroy function Return.' . json_encode($response));
        return $response;
    }
}
