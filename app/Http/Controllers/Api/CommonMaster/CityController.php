<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\CityService;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    protected $CityService;
    public function __construct(CityService $CityService)
    {
        $this->CityService = $CityService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CityService->index();
        Log::info('CityController ->index Return.' . json_encode($response));
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
        Log::info('CityController -> Store Inside.' . json_encode($request->all()));
        $response = $this->CityService->store($request->all());
        return $response;
        Log::info('CityController -> Store Return.' . json_encode($response));
    }
    public function cityValidation(Request $request)
    {
        Log::info('CityController-> validation Inside.' . json_encode($request->all()));
        $response = $this->CityService->ValidationForCity($request->all());
        return $response;
        Log::info('CityController -> validation Return.' . json_encode($response));
    }
    public function getCityByDistrictId(Request $request)
    {
        Log::info('CityController-> validation Inside.' . json_encode($request->all()));
        $response = $this->CityService->getCityByDistrictId($request->all());
        return $response;
        Log::info('CityController -> validation Return.' . json_encode($response));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CityController -> show Inside.' . json_encode($id));
        $response = $this->CityService->getCityById($id);
        return $response;
        Log::info('CityController ->show  Return.' . json_encode($response));
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
        Log::info('CityController -> destroy Inside.' . json_encode($id));
        $response = $this->CityService->destroyCityById($id);
        return $response;
        Log::info('CityController  ->destroy Return.' . json_encode($response));
    }
}
