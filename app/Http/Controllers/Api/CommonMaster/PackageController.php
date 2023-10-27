<?php

namespace App\Http\Controllers\Api\CommonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\CommonMaster\PackageService;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    protected $PackageService;
    public function __construct(PackageService $PackageService)
    {
        $this->PackageService = $PackageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->PackageService->index();
        Log::info('PackageController ->index Return.' . json_encode($response));
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

        Log::info('PackageController -> Store Inside.' . json_encode($request->all()));
        $response = $this->PackageService->store($request->all());
        return $response;
        Log::info('PackageController -> Store Return.' . json_encode($response));
    }
    public function packageValidation(Request $request)
    {
        Log::info('PackageController-> validation Inside.' . json_encode($request->all()));
        $response = $this->PackageService->ValidationForPackage($request->all());
        return $response;
        Log::info('PackageController -> validation Return.' . json_encode($response));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('PackageController -> show Inside.' . json_encode($id));
        $response = $this->PackageService->getPackageById($id);
        return $response;
        Log::info('PackageController  ->show  Return.' . json_encode($response));
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
        Log::info('PackageController -> destroy Inside.' . json_encode($id));
        $response = $this->PackageService->destroyPackageById($id);
        return $response;
        Log::info('PackageController  ->destroy Return.' . json_encode($response));
    }
}
