<?php

namespace App\Http\Controllers\Api\PFM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PFM\ValidationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class ValidationController extends Controller
{
    protected $ValidationService;
    public function __construct(ValidationService $ValidationService)
    {
        $this->ValidationService = $ValidationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->ValidationService->index();
        Log::info('ValidationController ->index Return.' . json_encode($response));
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
        Log::info('ValidationController-> Store Inside.' . json_encode($request->all()));
        $response = $this->ValidationService->store($request->all());
        return $response;
        Log::info('ValidationController -> Store Return.' . json_encode($response));
    }

    public function validation(Request $request){
        Log::info('ValidationController -> Validation Inside.' . json_encode($request->all()));
        $response = $this->ValidationService->ValidationForValidation($request->all());
        return $response;
        Log::info('ValidationController -> Validation Inside.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('ValidationController -> show Inside.' . json_encode($id));
        $response = $this->ValidationService->getValidationById($id);
        return $response;
        Log::info('ValidationController  ->show  Return.' . json_encode($response));
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
        Log::info('ValidationController -> destroy Inside.' . json_encode($id));
        $response = $this->ValidationService->destroyValidationById($id);
        return $response;
        Log::info('ValidationController  -> destroy Return.' . json_encode($response));
    }
}
