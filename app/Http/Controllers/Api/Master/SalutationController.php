<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\Master\SalutationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalutationController extends Controller
{  protected $salutationService;

    public function __construct(SalutationService $salutationService)
    {
        $this->salutationService = $salutationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Log::info('SalutationController-> index Inside.' . json_encode('yes'));
        $response = $this->salutationService->index();
        Log::info('HrmResourceController>Store Return.' . json_encode($response));
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
        Log::info('SalutationController-> index Inside.' . json_encode($request->all()));
        $response = $this->salutationService->store($request->all());
        return $response;
        Log::info('SalutationController>Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('SalutationController-> index Inside.' . json_encode($id));
        $response = $this->salutationService->getSalutationById($id);
        return $response;
        Log::info('HrmResourceController>Store Return.' . json_encode($response));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        Log::info('SalutationController-> destroy Inside.' . json_encode($id));
        $response = $this->salutationService->destroySalutationById($id);
        return $response;
        Log::info('HrmResourceController>destroy Return.' . json_encode($response));
    }
}
