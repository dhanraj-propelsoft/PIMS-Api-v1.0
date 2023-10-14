<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\AreaService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AreaController extends Controller
{
    protected $AreaService;
    public function __construct(AreaService $AreaService)
    {
        $this->AreaService = $AreaService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->AreaService->index();
        Log::info('CountryController ->index Return.' . json_encode($response));
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
        Log::info('AreaController-> Store Inside.' . json_encode($request->all()));
        $response = $this->AreaService->store($request->all());
        return $response;
        Log::info('AreaController -> Store Return.' . json_encode($response));
    }
    public function areaValidation(Request $request)
    {
        Log::info('AreaController-> validation Inside.' . json_encode($request->all()));
        $response = $this->AreaService->ValidationForArea($request->all());
        return $response;
        Log::info('AreaController -> validation Return.' . json_encode($response));
    }
    public function getAreaByCityId(Request $request)
    {
        Log::info('AreaController-> validation Inside.' . json_encode($request->all()));
        $response = $this->AreaService->getAreaByCityId($request->all());
        return $response;
        Log::info('AreaController -> validation Return.' . json_encode($response));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('AreaController -> show Inside.' . json_encode($id));
        $response = $this->AreaService->getAreaById($id);
        return $response;
        Log::info('AreaController  ->show  Return.' . json_encode($response));
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
        Log::info('AreaController -> destroy Inside.' . json_encode($id));
        $response = $this->AreaService->destroyAreaById($id);
        return $response;
        Log::info('AreaController  -> destroy Return.' . json_encode($response));
    }
}
