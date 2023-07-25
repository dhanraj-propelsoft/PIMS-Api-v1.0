<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgOwnerShipService;
use Illuminate\Support\Facades\Log;

class OrgOwnerShipController extends Controller
{
    protected $OrgOwnerShipService;
    public function __construct(OrgOwnerShipService $OrgOwnerShipService)
    {
        $this->OrgOwnerShipService = $OrgOwnerShipService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->OrgOwnerShipService->index();
        Log::info('OrgOwnerShipController -> index Return.' . json_encode($response));
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
        Log::info('OrgOwnerShipController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgOwnerShipService->store($request->all());
        return $response;
        Log::info('OrgOwnerShipController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgOwnerShipController -> show Inside.' . json_encode($id));
        $response = $this->OrgOwnerShipService->getOrgOwnerShipById($id);
        return $response;
        Log::info('OrgOwnerShipController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgOwnerShipController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgOwnerShipService->destroyOrgOwnerShipById($id);
        return $response;
        Log::info('OrgOwnerShipController  ->destroy Return.' . json_encode($response));
    }
}
