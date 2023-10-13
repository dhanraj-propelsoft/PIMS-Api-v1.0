<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\AuthorizationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AuthorizationController extends Controller
{
    protected $AuthorizationService;
    public function __construct(AuthorizationService $AuthorizationService)
    {
        $this->AuthorizationService = $AuthorizationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->AuthorizationService->index();
        Log::info('AuthorizationController ->index Return.' . json_encode($response));
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
        Log::info('AuthorizationController-> Store Inside.' . json_encode($request->all()));
        $response = $this->AuthorizationService->store($request->all());
        return $response;
        Log::info('AuthorizationController -> Store Return.' . json_encode($response));
    }

    public function validation(Request $request){
        Log::info('AuthorizationController -> Authorization Inside.' . json_encode($request->all()));
        $response = $this->AuthorizationService->ValidationForAuthorization($request->all());
        return $response;
        Log::info('AuthorizationController -> Authorization Inside.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('AuthorizationController -> show Inside.' . json_encode($id));
        $response = $this->AuthorizationService->getAuthorizationById($id);
        return $response;
        Log::info('AuthorizationController  ->show  Return.' . json_encode($response));
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
        Log::info('AuthorizationController -> destroy Inside.' . json_encode($id));
        $response = $this->AuthorizationService->destroyAuthorizationById($id);
        return $response;
        Log::info('AuthorizationController  -> destroy Return.' . json_encode($response));
    }
}
