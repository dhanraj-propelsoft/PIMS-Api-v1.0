<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\Master\CommonStateService;
use Illuminate\Support\Facades\Log;

class CommonStateController extends Controller
{
    protected $CommonStateService;
    public function __construct(CommonStateService $CommonStateService)
    {
        $this->CommonStateService = $CommonStateService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->CommonStateService->index();
        Log::info('CommonStateController ->index Return.' . json_encode($response));
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
        Log::info('CommonStateController-> Store Inside.' . json_encode($request->all()));
        $response = $this->CommonStateService->store($request->all());
        return $response;
        Log::info('CommonStateController ->Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CommonStateController -> show Inside.' . json_encode($id));
        $response = $this->CommonStateService->getStateById($id);
        return $response;
        Log::info('CommonStateController  -> show  Return.' . json_encode($response));
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
        Log::info('CommonStateController -> destroy Inside.' . json_encode($id));
        $response = $this->CommonStateService->destroyStateById($id);
        return $response;
        Log::info('CommonStateController -> destroy Return.' . json_encode($response));
    }
}