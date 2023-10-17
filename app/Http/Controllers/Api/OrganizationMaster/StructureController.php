<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\StructureService;
use Illuminate\Support\Facades\Log;

class StructureController extends Controller
{
    protected $StructureService;
    public function __construct(StructureService $StructureService)
    {
        $this->StructureService = $StructureService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->StructureService->index();
        Log::info('StructureController -> index Return.' . json_encode($response));
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

     public function StructureValidation(Request $request)
     {
         Log::info('StructureController  -> Validation Inside.' . json_encode($request->all()));
         $response = $this->StructureService->ValidationForStructure($request->all());
         return $response;
         Log::info('StructureController -> Validation Return.' . json_encode($response));
     }

    public function store(Request $request)
    {
        Log::info('StructureController -> Store Inside.' . json_encode($request->all()));
        $response = $this->StructureService->store($request->all());
        return $response;
        Log::info('StructureController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('StructureController -> show Inside.' . json_encode($id));
        $response = $this->StructureService->getStructureById($id);
        return $response;
        Log::info('StructureController  -> show  Return.' . json_encode($response));
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
        Log::info('StructureController -> destroy Inside.' . json_encode($id));
        $response = $this->StructureService->destroyStructureById($id);
        return $response;
        Log::info('StructureController  ->destroy Return.' . json_encode($response));
    }
}
