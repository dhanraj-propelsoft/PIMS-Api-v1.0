<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\PersonStageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class PersonStageController extends Controller
{
    protected $PersonStageService;
    public function __construct(PersonStageService $PersonStageService)
    {
        $this->PersonStageService = $PersonStageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->PersonStageService->index();
        Log::info('PersonStageController ->index Return.' . json_encode($response));
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
        Log::info('PersonStageController-> Store Inside.' . json_encode($request->all()));
        $response = $this->PersonStageService->store($request->all());
        return $response;
        Log::info('PersonStageController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('PersonStageController -> show Inside.' . json_encode($id));
        $response = $this->PersonStageService->getPersonStageById($id);
        return $response;
        Log::info('PersonStageController  ->show  Return.' . json_encode($response));
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
        Log::info('PersonStageController -> destroy Inside.' . json_encode($id));
        $response = $this->PersonStageService->destroyPersonStageById($id);
        return $response;
        Log::info('PersonStageController  -> destroy Return.' . json_encode($response));
    }
}
