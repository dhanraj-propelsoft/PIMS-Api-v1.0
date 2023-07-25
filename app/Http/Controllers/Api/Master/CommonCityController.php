<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\Master\CommonCityService;
use Illuminate\Support\Facades\Log;

class CommonCityController extends Controller
{
    protected $CommonCityService;
    public function __construct(CommonCityService $CommonCityService)
    {
        $this->CommonCityService = $CommonCityService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CommonCityService->index();
        Log::info('CommonCityController ->index Return.' . json_encode($response));
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
        Log::info('CommonCityController -> Store Inside.' . json_encode($request->all()));
        $response = $this->CommonCityService->store($request->all());
        return $response;
        Log::info('CommonCityController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CommonCityController -> show Inside.' . json_encode($id));
        $response = $this->CommonCityService->getCityById($id);
        return $response;
        Log::info('CommonCityController ->show  Return.' . json_encode($response));
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
        Log::info('CommonCityController -> destroy Inside.' . json_encode($id));
        $response = $this->CommonCityService->destroyCityById($id);
        return $response;
        Log::info('CommonCityController  ->destroy Return.' . json_encode($response));
    }
}
