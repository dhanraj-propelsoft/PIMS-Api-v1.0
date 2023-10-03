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
        return BusinessActivities::
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
    public function getBusinessActivitiesById($id)
    {
        return BusinessActivities::where('id',$id)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();

    }
    public function destroyBusinessActivities($id)
    {
        return BusinessActivities::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}