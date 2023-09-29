<?php

namespace App\Http\Controllers\Api\PersonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PersonMaster\BankAccountTypeService;
use Illuminate\Support\Facades\Log;

class BankAccountTypeController extends Controller
{
    protected $BankAccountTypeService;
    public function __construct(BankAccountTypeService $BankAccountTypeService)
    {
        $this->BankAccountTypeService = $BankAccountTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->BankAccountTypeService->index();
        Log::info('BankAccountTypeController ->index Return.' . json_encode($response));
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
        Log::info('BankAccountTypeController -> store Inside.' . json_encode($request->all()));
        $response = $this->BankAccountTypeService->store($request->all());
        return $response;
        Log::info('BankAccountTypeController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('BankAccountTypeController-> show >show Inside.' . json_encode($id));
        $response = $this->BankAccountTypeService->getBankAccountTypeById($id);
        return $response;
        Log::info('BankAccountTypeController ->show > Return.' . json_encode($response));
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
        Log::info('BankAccountTypeController-> destroy Inside.' . json_encode($id));
        $response = $this->BankAccountTypeService->destroyBankAccountTypeById($id);
        return $response;
        Log::info('BankAccountTypeController ->destroy Return.' . json_encode($response));
    }
}
