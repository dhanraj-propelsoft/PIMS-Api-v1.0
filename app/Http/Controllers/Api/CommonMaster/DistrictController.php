<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\DistrictService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class DistrictController extends Controller
{
    protected $DistrictService;
    public function __construct(DistrictService $DistrictService)
    {
        $this->DistrictService = $DistrictService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->DistrictService->index();
        Log::info('CountryController ->index Return.' . json_encode($response));
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
        Log::info('DistrictController-> Store Inside.' . json_encode($request->all()));
        $response = $this->DistrictService->store($request->all());
        return $response;
        Log::info('DistrictController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('DistrictController -> show Inside.' . json_encode($id));
        $response = $this->DistrictService->getDistrictById($id);
        return $response;
        Log::info('DistrictController  ->show  Return.' . json_encode($response));
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
        Log::info('DistrictController -> destroy Inside.' . json_encode($id));
        $response = $this->DistrictService->destroyDistrictById($id);
        return $response;
        Log::info('DistrictController  -> destroy Return.' . json_encode($response));
    }
}
