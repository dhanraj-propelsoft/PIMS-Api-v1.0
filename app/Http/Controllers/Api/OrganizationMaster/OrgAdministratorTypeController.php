<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgAdministratorTypeService;
use Illuminate\Support\Facades\Log;

class OrgAdministratorTypeController extends Controller
{
    protected $OrgAdministratorTypeService;
    public function __construct(OrgAdministratorTypeService $OrgAdministratorTypeService)
    {
        $this->OrgAdministratorTypeService = $OrgAdministratorTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->OrgAdministratorTypeService->index();
        Log::info('OrgAdministratorTypeController ->index Return.' . json_encode($response));
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
        Log::info('OrgAdministratorTypeController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgAdministratorTypeService->store($request->all());
        return $response;
        Log::info('OrgAdministratorTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgAdministratorTypeController -> show Inside.' . json_encode($id));
        $response = $this->OrgAdministratorTypeService->getOrgAdministratorTypeById($id);
        return $response;
        Log::info('OrgAdministratorTypeController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgAdministratorTypeController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgAdministratorTypeService->destroyOrgAdministratorTypeById($id);
        return $response;
        Log::info('OrgAdministratorTypeController  ->destroy Return.' . json_encode($response));
    }
}
