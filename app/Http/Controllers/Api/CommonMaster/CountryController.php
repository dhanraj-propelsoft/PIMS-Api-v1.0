<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\CountryService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class CountryController extends Controller
{
    protected $CountryService;
    public function __construct(CountryService $CountryService)
    {
        $this->CountryService = $CountryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CountryService->index();
        Log::info('CountryController ->index Return.' . json_encode($response));
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
        Log::info('CountryController-> Store Inside.' . json_encode($request->all()));
        $response = $this->CountryService->store($request->all());
        return $response;
        Log::info('CountryController -> Store Return.' . json_encode($response));
    }
    public function validation(Request $request)
    {
        Log::info('CountryController-> validation Inside.' . json_encode($request->all()));
        $response = $this->CountryService->ValidationForCountry($request->all());
        return $response;
        Log::info('CountryController -> validation Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CountryController -> show Inside.' . json_encode($id));
        $response = $this->CountryService->getCountryById($id);
        return $response;
        Log::info('CountryController  ->show  Return.' . json_encode($response));
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
        Log::info('CountryController -> destroy Inside.' . json_encode($id));
        $response = $this->CountryService->destroyCountryById($id);
        return $response;
        Log::info('CountryController  -> destroy Return.' . json_encode($response));
    }
}
