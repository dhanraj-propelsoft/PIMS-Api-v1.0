<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\OwnerShipService;
use Illuminate\Support\Facades\Log;

class OwnerShipController extends Controller
{
    protected $OwnerShipService;
    public function __construct(OwnerShipService $OwnerShipService)
    {
        $this->OwnerShipService = $OwnerShipService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->OwnerShipService->index();
        Log::info('OwnerShipController -> index Return.' . json_encode($response));
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

     public function OwnerShipValidation(Request $request)
     {
         Log::info('OwnerShipController  -> Validation Inside.' . json_encode($request->all()));
         $response = $this->OwnerShipService->ValidationForOwnership($request->all());
         return $response;
         Log::info('OwnerShipController -> Validation Return.' . json_encode($response));
     }

    public function store(Request $request)
    {
        Log::info('OwnerShipController -> Store Inside.' . json_encode($request->all()));
        $response = $this->OwnerShipService->store($request->all());
        return $response;
        Log::info('OwnerShipController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OwnerShipController -> show Inside.' . json_encode($id));
        $response = $this->OwnerShipService->getOwnerShipById($id);
        return $response;
        Log::info('OwnerShipController  -> show  Return.' . json_encode($response));
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
        Log::info('OwnerShipController -> destroy Inside.' . json_encode($id));
        $response = $this->OwnerShipService->destroyOwnerShipById($id);
        return $response;
        Log::info('OwnerShipController  ->destroy Return.' . json_encode($response));
    }
}
