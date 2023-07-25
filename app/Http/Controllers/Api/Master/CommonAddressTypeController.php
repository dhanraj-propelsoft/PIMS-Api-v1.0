<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\Master\CommonAddressTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommonAddressTypeController extends Controller
{
    protected $CommonAddressTypeService;
    public function __construct(CommonAddressTypeService $CommonAddressTypeService)
    {
        $this->CommonAddressTypeService = $CommonAddressTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->CommonAddressTypeService->index();
        Log::info('CommonAddressTypeController ->index Return.' . json_encode($response));
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
        Log::info('CommonAddressTypeController-> Store Inside.' . json_encode($request->all()));
        $response = $this->CommonAddressTypeService->store($request->all());
        return $response;
        Log::info('CommonAddressTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CommonAddressTypeController-> show  Inside.' . json_encode($id));
        $response = $this->CommonAddressTypeService->getCommonAddressTypeById($id);
        return $response;
        Log::info('CommonAddressTypeController ->show  Return.' . json_encode($response));
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
        Log::info('CommonAddressTypeController-> destroy Inside.' . json_encode($id));
        $response = $this->CommonAddressTypeService->destroyCommonAddressTypeById($id);
        return $response;
        Log::info('CommonAddressTypeController ->destroy Return.' . json_encode($response));
    }
}
