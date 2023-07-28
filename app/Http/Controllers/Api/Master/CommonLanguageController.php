<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\Master\CommonLanguageService;
use Illuminate\Support\Facades\Log;

class CommonLanguageController extends Controller
{
    protected $CommonLanguageService;
    public function __construct(CommonLanguageService $CommonLanguageService)
    {
        $this->CommonLanguageService = $CommonLanguageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CommonLanguageService->index();
        Log::info('CommonLanguageController ->index Return.' . json_encode($response));
        return $response;

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('CommonLanguageController -> Store Inside.' . json_encode($request->all()));
        $response = $this->CommonLanguageService->store($request->all());
        return $response;
        Log::info('CommonLanguageController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CommonLanguageController -> show Inside.' . json_encode($id));
        $response = $this->CommonLanguageService->getCommonLanguageById($id);
        return $response;
        Log::info('CommonLanguageController  ->show  Return.' . json_encode($response));
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
        Log::info('CommonLanguageController -> destroy Inside.' . json_encode($id));
        $response = $this->CommonLanguageService->destroyCommonLanguageById($id);
        return $response;
        Log::info('CommonLanguageController  ->destroy Return.' . json_encode($response));
    }
}