<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\StateService;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    protected $StateService;
    public function __construct(StateService $StateService)
    {
        $this->StateService = $StateService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->StateService->index();
        Log::info('StateController ->index Return.' . json_encode($response));
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
       
        Log::info('StateController-> Store Inside.' . json_encode($request->all()));
        $response = $this->StateService->store($request->all());
        return $response;
        Log::info('StateController ->Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('StateController -> show Inside.' . json_encode($id));
        $response = $this->StateService->getStateById($id);
        return $response;
        Log::info('StateController  -> show  Return.' . json_encode($response));
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
        Log::info('StateController -> destroy Inside.' . json_encode($id));
        $response = $this->StateService->destroyStateById($id);
        return $response;
        Log::info('StateController -> destroy Return.' . json_encode($response));
    }
}
