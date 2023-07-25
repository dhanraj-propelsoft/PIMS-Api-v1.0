<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgBusinessSectorService;
use Illuminate\Support\Facades\Log;

class OrgBusinessSectorController extends Controller
{
    protected $OrgBusinessSectorService;
    public function __construct(OrgBusinessSectorService $OrgBusinessSectorService)
    {
        $this->OrgBusinessSectorService = $OrgBusinessSectorService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->OrgBusinessSectorService->index();
        Log::info('OrgBusinessSectorController -> index Return.' . json_encode($response));
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
        Log::info('OrgBusinessSectorController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgBusinessSectorService->store($request->all());
        return $response;
        Log::info('OrgBusinessSectorController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgBusinessSectorController -> show Inside.' . json_encode($id));
        $response = $this->OrgBusinessSectorService->getOrgBusinessSectorById($id);
        return $response;
        Log::info('OrgBusinessSectorController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgBusinessSectorController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgBusinessSectorService->destroyOrgBusinessSectorById($id);
        return $response;
        Log::info('OrgBusinessSectorController  ->destroy Return.' . json_encode($response));
    }
}
