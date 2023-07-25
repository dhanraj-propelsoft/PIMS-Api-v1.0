<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OrgBusinessActivitiesService;
use Illuminate\Support\Facades\Log;


class OrgBusinessActivitiesController extends Controller
{
    protected $OrgBusinessActivitiesService;
    public function __construct(OrgBusinessActivitiesService $OrgBusinessActivitiesService)
    {
        $this->OrgBusinessActivitiesService = $OrgBusinessActivitiesService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->OrgBusinessActivitiesService->index();
        Log::info('OrgBusinessActivitiesController -> index Return.' . json_encode($response));
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
        Log::info('OrgBusinessActivitiesController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OrgBusinessActivitiesService->store($request->all());
        return $response;
        Log::info('OrgBusinessActivitiesController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OrgBusinessActivitiesController -> show Inside.' . json_encode($id));
        $response = $this->OrgBusinessActivitiesService->getOrgBusinessActivitiesById($id);
        return $response;
        Log::info('OrgBusinessActivitiesController  -> show  Return.' . json_encode($response));
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
        Log::info('OrgBusinessActivitiesController -> destroy Inside.' . json_encode($id));
        $response = $this->OrgBusinessActivitiesService->destroyOrgBusinessActivitiesById($id);
        return $response;
        Log::info('OrgBusinessActivitiesController  ->destroy Return.' . json_encode($response));
    }
}
