<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\OriginService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class OriginController extends Controller
{
    protected $OriginService;
    public function __construct(OriginService $OriginService)
    {
        $this->OriginService = $OriginService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->OriginService->index();
        Log::info('OriginController ->index Return.' . json_encode($response));
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
        Log::info('OriginController-> Store Inside.' . json_encode($request->all()));
        $response = $this->OriginService->store($request->all());
        return $response;
        Log::info('OriginController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('OriginController -> show Inside.' . json_encode($id));
        $response = $this->OriginService->getOriginById($id);
        return $response;
        Log::info('OriginController  ->show  Return.' . json_encode($response));
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
        Log::info('OriginController -> destroy Inside.' . json_encode($id));
        $response = $this->OriginService->destroyOriginById($id);
        return $response;
        Log::info('OriginController  -> destroy Return.' . json_encode($response));
    }
}
