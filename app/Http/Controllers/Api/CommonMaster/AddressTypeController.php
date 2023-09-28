<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\CommonMaster\AddressTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressTypeController extends Controller
{
    protected $AddressTypeService;
    public function __construct(AddressTypeService $AddressTypeService)
    {
        $this->AddressTypeService = $AddressTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->AddressTypeService->index();
        Log::info('AddressTypeController ->index Return.' . json_encode($response));
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
        
        Log::info('AddressTypeController-> Store Inside.' . json_encode($request->all()));
        $response = $this->AddressTypeService->store($request->all());
        return $response;
        Log::info('AddressTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('AddressTypeController-> show  Inside.' . json_encode($id));
        $response = $this->AddressTypeService->getAddressTypeById($id);
        return $response;
        Log::info('AddressTypeController ->show  Return.' . json_encode($response));
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
        Log::info('AddressTypeController-> destroy Inside.' . json_encode($id));
        $response = $this->AddressTypeService->destroyAddressTypeById($id);
        return $response;
        Log::info('AddressTypeController ->destroy Return.' . json_encode($response));
    }
}
