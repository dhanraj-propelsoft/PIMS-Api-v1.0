<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgDocumentTypeService;
use Illuminate\Support\Facades\Log;

class OrgDocumentTypeController extends Controller
{
    protected $OrgDocumentTypeService;
    public function __construct(OrgDocumentTypeService $OrgDocumentTypeService)
    {
        $this->OrgDocumentTypeService = $OrgDocumentTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->OrgDocumentTypeService->index();
        Log::info('OrgDocumentTypeController -> index Return.' . json_encode($response));
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
        Log::info('OrgDocumentTypeController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgDocumentTypeService->store($request->all());
        return $response;
        Log::info('OrgDocumentTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgDocumentTypeController -> show Inside.' . json_encode($id));
        $response = $this->OrgDocumentTypeService->getOrgDocumentTypeById($id);
        return $response;
        Log::info('OrgDocumentTypeController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgDocumentTypeController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgDocumentTypeService->destroyOrgDocumentTypeById($id);
        return $response;
        Log::info('OrgDocumentTypeController  ->destroy Return.' . json_encode($response));
    }
}
