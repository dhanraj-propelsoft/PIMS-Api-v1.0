<?php

namespace App\Http\Controllers\Api\OrganizationMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\OrganizationMaster\CategoryService;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $CategoryService;
    public function __construct(CategoryService $CategoryService)
    {
        $this->CategoryService = $CategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $response = $this->CategoryService->index();
        Log::info('CategoryController -> index Return.' . json_encode($response));
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

     public function CategoryValidation(Request $request)
     {
         Log::info('CategoryController  -> Validation Inside.' . json_encode($request->all()));
         $response = $this->CategoryService->ValidationForCategory($request->all());
         return $response;
         Log::info('CategoryController -> Validation Return.' . json_encode($response));
     }
    public function store(Request $request)
    {
        Log::info('CategoryController -> Store Inside.' . json_encode($request->all()));
        $response = $this->CategoryService->store($request->all());
        return $response;
        Log::info('CategoryController -> Store Return.' . json_encode($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('CategoryController -> show Inside.' . json_encode($id));
        $response = $this->CategoryService->getCategoryById($id);
        return $response;
        Log::info('CategoryController  -> show  Return.' . json_encode($response));
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
        Log::info('CategoryController -> destroy Inside.' . json_encode($id));
        $response = $this->CategoryService->destroyCategoryById($id);
        return $response;
        Log::info('CategoryController  ->destroy Return.' . json_encode($response));
    }
}
