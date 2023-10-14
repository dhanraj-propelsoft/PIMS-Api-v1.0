<?php

namespace App\Http\Controllers\Api\PersonMaster;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\PersonMaster\GenderService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class GenderController extends Controller
{
    protected $GenderService;
    public function __construct(GenderService $GenderService)
    {
        $this->GenderService = $GenderService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->GenderService->index();
        Log::info('GenderController ->index Return.' . json_encode($response));
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

        Log::info('GenderController-> Store Inside.' . json_encode($request->all()));
        $response = $this->GenderService->store($request->all());
        return $response;
        Log::info('GenderController>Store Return.' . json_encode($response));
    }
    public function genderValidation(Request $request)
    {

        Log::info('GenderController-> Store Inside.' . json_encode($request->all()));
        $response = $this->GenderService->ValidationForGender($request->all());
        return $response;
        Log::info('GenderController>Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          Log::info('GenderController-> show Inside.' . json_encode($id));
        $response = $this->GenderService->getGenderById($id);
        return $response;
        Log::info('GenderController ->show  Return.' . json_encode($response));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('GenderController-> destroy Inside.' . json_encode($id));
        $response = $this->GenderService->destroyGenderById($id);
        return $response;
        Log::info('GenderController ->destroy Return.' . json_encode($response));
    }
}
