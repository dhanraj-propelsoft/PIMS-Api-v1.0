<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessActivitiesInterface;
use App\Models\PimsOrgBusinessActivities;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgBusinessActivitiesRepository implements OrgBusinessActivitiesInterface
{
    public function index()
    {
        return PimsOrgBusinessActivities::whereNull('deleted_at')->get();
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
    public function getOrgBusinessActivitiesById($id)
    {
        return PimsOrgBusinessActivities::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgBusinessActivities($id)
    {
        return PimsOrgBusinessActivities::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}