<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\MaritalStatusInterface;
use App\Models\MaritalStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaritalStatusRepository implements MaritalStatusInterface
{
    public function index()
    {
        return MaritalStatus::with('activeStatus')
    
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
    public function getMaritalStatusById($maritalId)
    {
        return MaritalStatus::with('activeStatus')->where('id',$maritalId)
        ->whereNull('deleted_flag')->first();


    }
    public function destroyMaritalStatus($maritalId)
    {
        return MaritalStatus::where('id', $maritalId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }

}