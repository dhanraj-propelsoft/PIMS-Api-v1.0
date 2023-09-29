<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\DeponeStatusService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class DeponeStatusController extends Controller
{
    protected $DeponeStatusService;
    public function __construct(DeponeStatusService $DeponeStatusService)
    {
        $this->DeponeStatusService = $DeponeStatusService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->DeponeStatusService->index();
        Log::info('DeponeStatusController ->index Return.' . json_encode($response));
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
        Log::info('DeponeStatusController-> Store Inside.' . json_encode($request->all()));
        $response = $this->DeponeStatusService->store($request->all());
        return $response;
        Log::info('DeponeStatusController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('DeponeStatusController -> show Inside.' . json_encode($id));
        $response = $this->DeponeStatusService->getDeponeStatusById($id);
        return $response;
        Log::info('DeponeStatusController  ->show  Return.' . json_encode($response));
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
        Log::info('DeponeStatusController -> destroy Inside.' . json_encode($id));
        $response = $this->DeponeStatusService->destroyDeponeStatusById($id);
        return $response;
        Log::info('DeponeStatusController  -> destroy Return.' . json_encode($response));
    }
}
