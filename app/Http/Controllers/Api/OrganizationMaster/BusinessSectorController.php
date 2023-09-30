<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\BusinessSectorService;
use Illuminate\Support\Facades\Log;

class BusinessSectorController extends Controller
{
    protected $BusinessSectorService;
    public function __construct(BusinessSectorService $BusinessSectorService)
    {
        $this->BusinessSectorService = $BusinessSectorService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->BusinessSectorService->index();
        Log::info('BusinessSectorController -> index Return.' . json_encode($response));
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
        Log::info('BusinessSectorController -> Store Inside.' . json_encode($request->all()));
        $response = $this->BusinessSectorService->store($request->all());
        return $response;
        Log::info('BusinessSectorController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('BusinessSectorController -> show Inside.' . json_encode($id));
        $response = $this->BusinessSectorService->getBusinessSectorById($id);
        return $response;
        Log::info('BusinessSectorController  -> show  Return.' . json_encode($response));
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
        Log::info('BusinessSectorController -> destroy Inside.' . json_encode($id));
        $response = $this->BusinessSectorService->destroyBusinessSectorById($id);
        return $response;
        Log::info('BusinessSectorController  ->destroy Return.' . json_encode($response));
    }
}
