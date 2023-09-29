<?php

namespace App\Http\Controllers\Api\PersonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PersonMaster\MaritalStatusService;
use Illuminate\Support\Facades\Log;

class MaritalStatusController extends Controller
{
    protected $MaritalStatusService;
    public function __construct(MaritalStatusService $MaritalStatusService)
    {
        $this->MaritalStatusService = $MaritalStatusService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->MaritalStatusService->index();
        Log::info('MaritalStatusController ->Store Return.' . json_encode($response));
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
        Log::info('MaritalStatusController-> index Inside.' . json_encode($request->all()));
        $response = $this->MaritalStatusService->store($request->all());
        return $response;
        Log::info('MaritalStatusController >Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('MaritalStatusController-> show >index Inside.' . json_encode($id));
        $response = $this->MaritalStatusService->getMaritalStatusById($id);
        return $response;
        Log::info('MaritalStatusController ->show > Return.' . json_encode($response));
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
        Log::info('MaritalStatusController-> destroy Inside.' . json_encode($id));
        $response = $this->MaritalStatusService->destroyMaritalStatusById($id);
        return $response;
        Log::info('MaritalStatusController ->destroy Return.' . json_encode($response));
    }
}
