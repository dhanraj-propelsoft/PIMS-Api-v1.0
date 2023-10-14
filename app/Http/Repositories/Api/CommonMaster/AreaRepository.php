<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\AreaInterface;
use App\Models\Area;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class AreaRepository implements AreaInterface
{
    public function index()
    {
        return Area::with('activeStatus','city.district.state.country')
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
    public function getAreaById($areaId)
    {
        return Area::with('activeStatus','city.district.state.country')->where('id',$areaId)
            ->whereNull('deleted_flag')->first();

    }
    public function destroyArea($areaId)
    {
        return Area::where('id', $areaId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
        
        
    }
    public function checkAreaForCityId($cityId)
    {
       
        return Area::where('city_id', $cityId)->whereNull('deleted_flag')
        ->get();   
    }

}
