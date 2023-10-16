<?php

namespace App\Http\Controllers\Api\PersonMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\PersonMaster\BankService;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{
    protected $BankService;
    public function __construct(BankService $BankService)
    {
        $this->BankService = $BankService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->BankService->index();
        Log::info('BankController ->index Return.' . json_encode($response));
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
        Log::info('BankController-> Store Inside.' . json_encode($request->all()));
        $response = $this->BankService->store($request->all());
        return $response;
        Log::info('BankController>Store Return.' . json_encode($response));
    }
    public function bankValidation(Request $request)
    {
        Log::info('BankController-> Store Inside.' . json_encode($request->all()));
        $response = $this->BankService->ValidationForBank($request->all());
        return $response;
        Log::info('BankController>Store Return.' . json_encode($response));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('BankController-> show >index Inside.' . json_encode($id));
        $response = $this->BankService->getBankById($id);
        return $response;
        Log::info('BankController ->show > Return.' . json_encode($response));
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
        Log::info('BankController-> destroy Inside.' . json_encode($id));
        $response = $this->BankService->destroyBankById($id);
        return $response;
        Log::info('BankController ->destroy Return.' . json_encode($response));
    }
}
