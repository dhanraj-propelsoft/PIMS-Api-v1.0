<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessSectorInterface;
use App\Models\Organization\BusinessSector;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BusinessSectorRepository implements BusinessSectorInterface
{
    public function index()
    {

        return BusinessSector::where('pfm_active_status_id', 1)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')
        ->get();   ;
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
    public function getBusinessSectorById($id)
    {
        return BusinessSector::where(['id'=>$id,'pfm_active_status_id'=>1])
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();

    }
    public function destroyBusinessSector($id)
    {
        return BusinessSector::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}