<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\BusinessSaleSubsetService;
use Illuminate\Support\Facades\Log;

class BusinessSaleSubsetController extends Controller
{
    protected $BusinessSaleSubsetService;
    public function __construct(BusinessSaleSubsetService $BusinessSaleSubsetService)
    {
        $this->BusinessSaleSubsetService = $BusinessSaleSubsetService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->BusinessSaleSubsetService->index();
        Log::info('BusinessSaleSubsetController -> index Return.' . json_encode($response));
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

     public function BusinessSaleSubsetValidation(Request $request)
     {
         Log::info('BusinessSaleSubsetController  -> Validation Inside.' . json_encode($request->all()));
         $response = $this->BusinessSaleSubsetService->ValidationForBusinessSaleSubset($request->all());
         return $response;
         Log::info('BusinessSaleSubsetController -> Validation Return.' . json_encode($response));
     }

    public function store(Request $request)
    {

        Log::info('BusinessSaleSubsetController -> Store Inside.' . json_encode($request->all()));
        $response = $this->BusinessSaleSubsetService->store($request->all());
        return $response;
        Log::info('BusinessSaleSubsetController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        Log::info('BusinessSaleSubsetController -> show Inside.' . json_encode($id));
        $response = $this->BusinessSaleSubsetService->getBusinessSaleSubsetById($id);
        return $response;
        Log::info('BusinessSaleSubsetController  -> show  Return.' . json_encode($response));
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
        Log::info('BusinessSaleSubsetController -> destroy Inside.' . json_encode($id));
        $response = $this->BusinessSaleSubsetService->destroyBusinessSaleSubsetById($id);
        return $response;
        Log::info('BusinessSaleSubsetController  ->destroy Return.' . json_encode($response));
    }
}
