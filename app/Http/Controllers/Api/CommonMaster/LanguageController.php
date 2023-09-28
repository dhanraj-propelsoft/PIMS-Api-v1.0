<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\LanguageService;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    protected $LanguageService;
    public function __construct(LanguageService $LanguageService)
    {
        $this->LanguageService = $LanguageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->LanguageService->index();
        Log::info('LanguageController ->index Return.' . json_encode($response));
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
        
        Log::info('LanguageController -> Store Inside.' . json_encode($request->all()));
        $response = $this->LanguageService->store($request->all());
        return $response;
        Log::info('LanguageController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('LanguageController -> show Inside.' . json_encode($id));
        $response = $this->LanguageService->getLanguageById($id);
        return $response;
        Log::info('LanguageController  ->show  Return.' . json_encode($response));
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
        Log::info('LanguageController -> destroy Inside.' . json_encode($id));
        $response = $this->LanguageService->destroyLanguageById($id);
        return $response;
        Log::info('LanguageController  ->destroy Return.' . json_encode($response));
    }
}
