<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\ActiveStatusService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class ActiveStatusController extends Controller
{
    protected $ActiveStatusService;
    public function __construct(ActiveStatusService $ActiveStatusService)
    {
        $this->ActiveStatusService = $ActiveStatusService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->ActiveStatusService->index();
        Log::info('ActiveStatusController ->index Return.' . json_encode($response));
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
        Log::info('ActiveStatusController-> Store Inside.' . json_encode($request->all()));
        $response = $this->ActiveStatusService->store($request->all());
        return $response;
        Log::info('ActiveStatusController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('ActiveStatusController -> show Inside.' . json_encode($id));
        $response = $this->ActiveStatusService->getActiveStatusById($id);
        return $response;
        Log::info('ActiveStatusController  ->show  Return.' . json_encode($response));
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
        Log::info('ActiveStatusController -> destroy Inside.' . json_encode($id));
        $response = $this->ActiveStatusService->destroyActiveStatusById($id);
        return $response;
        Log::info('ActiveStatusController  -> destroy Return.' . json_encode($response));
    }
}
