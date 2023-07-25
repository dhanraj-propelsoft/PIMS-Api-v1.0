<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\Master\CommonCountryService;
use Illuminate\Support\Facades\Log;

class CommonCountryController extends Controller
{
    protected $CommonCountryService;
    public function __construct(CommonCountryService $CommonCountryService)
    {
        $this->CommonCountryService = $CommonCountryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CommonCountryService->index();
        Log::info('CommonCountryController ->index Return.' . json_encode($response));
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
        Log::info('CommonCountryController-> Store Inside.' . json_encode($request->all()));
        $response = $this->CommonCountryService->store($request->all());
        return $response;
        Log::info('CommonCountryController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CommonCountryController -> show Inside.' . json_encode($id));
        $response = $this->CommonCountryService->getCommonCountryById($id);
        return $response;
        Log::info('CommonCountryController  ->show  Return.' . json_encode($response));
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
        Log::info('CommonCountryController -> destroy Inside.' . json_encode($id));
        $response = $this->CommonCountryService->destroyCountryById($id);
        return $response;
        Log::info('CommonCountryController  -> destroy Return.' . json_encode($response));
    }
}
