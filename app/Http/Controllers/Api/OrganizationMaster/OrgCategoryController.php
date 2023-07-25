<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgCategoryService;
use Illuminate\Support\Facades\Log;

class OrgCategoryController extends Controller
{
    protected $OrgCategoryService;
    public function __construct(OrgCategoryService $OrgCategoryService)
    {
        $this->OrgCategoryService = $OrgCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->OrgCategoryService->index();
        Log::info('OrgCategoryController -> index Return.' . json_encode($response));
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
        Log::info('OrgCategoryController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgCategoryService->store($request->all());
        return $response;
        Log::info('OrgCategoryController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgCategoryController -> show Inside.' . json_encode($id));
        $response = $this->OrgCategoryService->getOrgCategoryById($id);
        return $response;
        Log::info('OrgCategoryController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgCategoryController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgCategoryService->destroyOrgCategoryById($id);
        return $response;
        Log::info('OrgCategoryController  ->destroy Return.' . json_encode($response));
    }
}
