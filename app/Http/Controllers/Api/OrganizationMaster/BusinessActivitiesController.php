<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\BusinessActivitiesService;
use Illuminate\Support\Facades\Log;


class BusinessActivitiesController extends Controller
{
    protected $BusinessActivitiesService;
    public function __construct(BusinessActivitiesService $BusinessActivitiesService)
    {
        $this->BusinessActivitiesService = $BusinessActivitiesService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->BusinessActivitiesService->index();
        Log::info('BusinessActivitiesController -> index Return.' . json_encode($response));
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
        Log::info('BusinessActivitiesController -> Store Inside.' . json_encode($request->all()));
        $response = $this->BusinessActivitiesService->store($request->all());
        return $response;
        Log::info('BusinessActivitiesController -> Store Return.' . json_encode($response));
    }
    public function businessActivityValidation(Request $request)
    {
        Log::info('BusinessActivitiesController -> Store Inside.' . json_encode($request->all()));
        $response = $this->BusinessActivitiesService->ValidationForBusinessActivity($request->all());
        return $response;
        Log::info('BusinessActivitiesController -> Store Return.' . json_encode($response));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('BusinessActivitiesController -> show Inside.' . json_encode($id));
        $response = $this->BusinessActivitiesService->getBusinessActivitiesById($id);
        return $response;
        Log::info('BusinessActivitiesController  -> show  Return.' . json_encode($response));
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
        Log::info('BusinessActivitiesController -> destroy Inside.' . json_encode($id));
        $response = $this->BusinessActivitiesService->destroyBusinessActivitiesById($id);
        return $response;
        Log::info('BusinessActivitiesController  ->destroy Return.' . json_encode($response));
    }
}
