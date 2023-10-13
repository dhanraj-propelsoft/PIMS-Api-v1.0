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
        return City::with('district','activeStatus','district.state.country')
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
    public function getCityById($cityId)
    {
        return City::with('district','activeStatus','district.state.country')->where('id',$cityId)
        ->whereNull('deleted_flag')->first();


    }
    public function destroyCity($cityId)
    {
        return City::where('id', $cityId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
    public function getALlCity()
    {
        return City::
       
        whereNull('deleted_flag')
        ->get();   
        }
    public function checkCityForDistrictId($districtId)
    {
        return City::where('district_id', $districtId)->whereNull('deleted_flag')
        ->get();   
    }
}