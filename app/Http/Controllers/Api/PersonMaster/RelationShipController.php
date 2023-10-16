<?php

namespace App\Http\Controllers\Api\PersonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PersonMaster\RelationShipService;
use Illuminate\Support\Facades\Log;

class RelationShipController extends Controller
{
    protected $RelationShipService;
    public function __construct(RelationShipService $RelationShipService)
    {
        $this->RelationShipService = $RelationShipService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->RelationShipService->index();
        Log::info('RelationShipController ->Store Return.' . json_encode($response));
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
        Log::info('RelationShipController-> index Inside.' . json_encode($request->all()));
        $response = $this->RelationShipService->store($request->all());
        return $response;
        Log::info('RelationShipController >Store Return.' . json_encode($response));
    }
    public function relationshipValidation(Request $request)
    {
        Log::info('RelationShipController-> index Inside.' . json_encode($request->all()));
        $response = $this->RelationShipService->ValidationForRelationship($request->all());
        return $response;
        Log::info('RelationShipController >Store Return.' . json_encode($response));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('RelationShipController-> show >index Inside.' . json_encode($id));
        $response = $this->RelationShipService->getRelationShipById($id);
        return $response;
        Log::info('RelationShipController ->show > Return.' . json_encode($response));
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
        $response = $this->RelationShipService->destroyRelationShipById($id);
        return $response;
        Log::info('MaritalStatusController ->destroy Return.' . json_encode($response));
    }
}
