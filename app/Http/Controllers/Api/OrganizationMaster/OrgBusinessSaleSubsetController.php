<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgBusinessSaleSubsetService;
use Illuminate\Support\Facades\Log;

class OrgBusinessSaleSubsetController extends Controller
{
    protected $OrgBusinessSaleSubsetService;
    public function __construct(OrgBusinessSaleSubsetService $OrgBusinessSaleSubsetService)
    {
        $this->OrgBusinessSaleSubsetService = $OrgBusinessSaleSubsetService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->OrgBusinessSaleSubsetService->index();
        Log::info('OrgBusinessSaleSubsetController -> index Return.' . json_encode($response));
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

        Log::info('OrgBusinessSaleSubsetController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgBusinessSaleSubsetService->store($request->all());
        return $response;
        Log::info('OrgBusinessSaleSubsetController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        Log::info('OrgBusinessSaleSubsetController -> show Inside.' . json_encode($id));
        $response = $this->OrgBusinessSaleSubsetService->getOrgBusinessSaleSubsetById($id);
        return $response;
        Log::info('OrgBusinessSaleSubsetController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgBusinessSaleSubsetController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgBusinessSaleSubsetService->destroyOrgBusinessSaleSubsetById($id);
        return $response;
        Log::info('OrgBusinessSaleSubsetController  ->destroy Return.' . json_encode($response));
    }
}
