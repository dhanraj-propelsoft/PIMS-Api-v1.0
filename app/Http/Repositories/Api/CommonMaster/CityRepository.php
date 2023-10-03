<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CityInterface;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CityRepository implements CityInterface
{
    public function index()
    {
        return City::
        whereNull('deleted_at')
        ->whereNull('deleted_flag')
        ->get();   
     }
    public function store($model)
    {
        try {
            $result = DB::transaction(function () use ($model) {

                $model->save();
                return [
                    'message' => "Success",
                    'data' => $model,
                ];
            });

            return $result;
        } catch (\Exception $e) {

            return [

                'message' => "failed",
                'data' => $e,
            ];
        }
    }
    public function getCityById($id)
    {
        return City::where('id',$id)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();


    }
    public function destroyCity($id)
    {
        return City::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}