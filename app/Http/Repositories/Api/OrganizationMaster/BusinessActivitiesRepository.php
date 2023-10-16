<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessActivitiesInterface;
use App\Models\Organization\BusinessActivities;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BusinessActivitiesRepository implements BusinessActivitiesInterface
{
    public function index()
    {
        return BusinessActivities::with('activeStatus')
       
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
    public function getBusinessActivitiesById($businessActivityId)
    {
        return BusinessActivities::with('activeStatus')->where('id',$businessActivityId)
        ->whereNull('deleted_flag')->first();

    }
    public function destroyBusinessActivities($businessActivityId)
    {
        return BusinessActivities::where('id', $businessActivityId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}