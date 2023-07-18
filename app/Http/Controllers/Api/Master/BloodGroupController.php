<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\Master\BloodGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloodGroupController extends Controller
{
    protected $BloodGroupService;
    public function __construct(BloodGroupService $BloodGroupService)
    {
        $this->BloodGroupService = $BloodGroupService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->BloodGroupService->index();
        Log::info('BloodGroupController ->Store Return.' . json_encode($response));
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
        Log::info('BloodGroupController-> index Inside.' . json_encode($request->all()));
        $response = $this->BloodGroupService->store($request->all());
        return $response;
        Log::info('BloodGroupController >Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('BloodGroupController-> show >index Inside.' . json_encode($id));
        $response = $this->BloodGroupService->getBloodGroupById($id);
        return $response;
        Log::info('BloodGroupController ->show > Return.' . json_encode($response));
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
        Log::info('BloodGroupController-> destroy Inside.' . json_encode($id));
        $response = $this->BloodGroupService->destroyBloodGroupById($id);
        return $response;
        Log::info('BloodGroupController ->destroy Return.' . json_encode($response));
    }
}
