<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\CachetService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class CachetController extends Controller
{
    protected $CachetService;
    public function __construct(CachetService $CachetService)
    {
        $this->CachetService = $CachetService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CachetService->index();
        Log::info('CachetController ->index Return.' . json_encode($response));
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
        Log::info('CachetController-> Store Inside.' . json_encode($request->all()));
        $response = $this->CachetService->store($request->all());
        return $response;
        Log::info('CachetController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CachetController -> show Inside.' . json_encode($id));
        $response = $this->CachetService->getCachetById($id);
        return $response;
        Log::info('CachetController  ->show  Return.' . json_encode($response));
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
        Log::info('CachetController -> destroy Inside.' . json_encode($id));
        $response = $this->CachetService->destroyCachetById($id);
        return $response;
        Log::info('CachetController  -> destroy Return.' . json_encode($response));
    }
}
