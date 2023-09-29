<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgStructureService;
use Illuminate\Support\Facades\Log;

class OrgStructureController extends Controller
{
    protected $OrgStructureService;
    public function __construct(OrgStructureService $OrgStructureService)
    {
        $this->OrgStructureService = $OrgStructureService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->OrgStructureService->index();
        Log::info('OrgStructureController -> index Return.' . json_encode($response));
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
        Log::info('OrgStructureController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgStructureService->store($request->all());
        return $response;
        Log::info('OrgStructureController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgStructureController -> show Inside.' . json_encode($id));
        $response = $this->OrgStructureService->getOrgStructureById($id);
        return $response;
        Log::info('OrgStructureController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgStructureController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgStructureService->destroyOrgStructureById($id);
        return $response;
        Log::info('OrgStructureController  ->destroy Return.' . json_encode($response));
    }
}
