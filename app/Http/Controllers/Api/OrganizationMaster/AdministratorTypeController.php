<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\AdministratorTypeService;
use Illuminate\Support\Facades\Log;

class AdministratorTypeController extends Controller
{
    protected $AdministratorTypeService;
    public function __construct(AdministratorTypeService $AdministratorTypeService)
    {
        $this->AdministratorTypeService = $AdministratorTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->AdministratorTypeService->index();
        Log::info('AdministratorTypeController ->index Return.' . json_encode($response));
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
        Log::info('AdministratorTypeController -> Store Inside.' . json_encode($request->all()));
        $response = $this->AdministratorTypeService->store($request->all());
        return $response;
        Log::info('AdministratorTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('AdministratorTypeController -> show Inside.' . json_encode($id));
        $response = $this->AdministratorTypeService->getAdministratorTypeById($id);
        return $response;
        Log::info('AdministratorTypeController  -> show  Return.' . json_encode($response));
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
        Log::info('AdministratorTypeController -> destroy Inside.' . json_encode($id));
        $response = $this->AdministratorTypeService->destroyAdministratorTypeById($id);
        return $response;
        Log::info('AdministratorTypeController  ->destroy Return.' . json_encode($response));
    }
}
