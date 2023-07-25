<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\Master\DocumentTypeService;
use Illuminate\Support\Facades\Log;

class DocumentTypeController extends Controller
{
    protected $DocumentTypeService;
    public function __construct(DocumentTypeService $DocumentTypeService)
    {
        $this->DocumentTypeService = $DocumentTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->DocumentTypeService->index();
        Log::info('DocumentTypeController ->index Return.' . json_encode($response));
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
        Log::info('DocumentTypeController -> Store Inside.' . json_encode($request->all()));
        $response = $this->DocumentTypeService->store($request->all());
        return $response;
        Log::info('DocumentTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('DocumentTypeController -> show Inside.' . json_encode($id));
        $response = $this->DocumentTypeService->getDocumentTypeById($id);
        return $response;
        Log::info('DocumentTypeController  ->show  Return.' . json_encode($response));
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
        Log::info('DocumentTypeController -> destroy Inside.' . json_encode($id));
        $response = $this->DocumentTypeService->destroyDocumentTypeById($id);
        return $response;
        Log::info('DocumentTypeController  ->destroy Return.' . json_encode($response));
    }
}
