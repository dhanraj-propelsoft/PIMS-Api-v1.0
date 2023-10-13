<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\ExistenceService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class ExistenceController extends Controller
{
    protected $ExistenceService;
    public function __construct(ExistenceService $ExistenceService)
    {
        $this->ExistenceService = $ExistenceService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->ExistenceService->index();
        Log::info('ExistenceController ->index Return.' . json_encode($response));
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
        Log::info('ExistenceController-> Store Inside.' . json_encode($request->all()));
        $response = $this->ExistenceService->store($request->all());
        return $response;
        Log::info('ExistenceController -> Store Return.' . json_encode($response));
    }

    public function validation(Request $request){
        Log::info('ExistenceController -> Existence Inside.' . json_encode($request->all()));
        $response = $this->ExistenceService->ValidationForExistence($request->all());
        return $response;
        Log::info('ExistenceController -> Existence Inside.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('ExistenceController -> show Inside.' . json_encode($id));
        $response = $this->ExistenceService->getExistenceById($id);
        return $response;
        Log::info('ExistenceController  ->show  Return.' . json_encode($response));
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
        Log::info('ExistenceController -> destroy Inside.' . json_encode($id));
        $response = $this->ExistenceService->destroyExistenceById($id);
        return $response;
        Log::info('ExistenceController  -> destroy Return.' . json_encode($response));
    }
}
