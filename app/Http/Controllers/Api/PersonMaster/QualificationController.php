<?php

namespace App\Http\Controllers\Api\PersonMaster;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\PersonMaster\QualificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QualificationController extends Controller
{
    protected $QualificationService;

    public function __construct(QualificationService $QualificationService)
    {
        $this->QualificationService = $QualificationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $response = $this->QualificationService->index();
        Log::info('QualificationController ->index Return.' . json_encode($response));
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
        Log::info('QualificationController-> Store Inside.' . json_encode($request->all()));
        $response = $this->QualificationService->store($request->all());
        return $response;
        Log::info('QualificationController>Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('QualificationController-> show Inside.' . json_encode($id));
        $response = $this->QualificationService->getQualificationById($id);
        return $response;
        Log::info('QualificationController ->show  Return.' . json_encode($response));
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
        Log::info('QualificationController-> destroy Inside.' . json_encode($id));
        $response = $this->QualificationService->destroyQualificationById($id);
        return $response;
        Log::info('QualificationController ->destroy Return.' . json_encode($response));
    }
}
