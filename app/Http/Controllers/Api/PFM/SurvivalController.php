<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\SurvivalService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class SurvivalController extends Controller
{
    protected $SurvivalService;
    public function __construct(SurvivalService $SurvivalService)
    {
        $this->SurvivalService = $SurvivalService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->SurvivalService->index();
        Log::info('SurvivalController ->index Return.' . json_encode($response));
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
        Log::info('SurvivalController-> Store Inside.' . json_encode($request->all()));
        $response = $this->SurvivalService->store($request->all());
        return $response;
        Log::info('SurvivalController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('SurvivalController -> show Inside.' . json_encode($id));
        $response = $this->SurvivalService->getSurvivalById($id);
        return $response;
        Log::info('SurvivalController  ->show  Return.' . json_encode($response));
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
        Log::info('SurvivalController -> destroy Inside.' . json_encode($id));
        $response = $this->SurvivalService->destroySurvivalById($id);
        return $response;
        Log::info('SurvivalController  -> destroy Return.' . json_encode($response));
    }
}
