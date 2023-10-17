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

        return BusinessSector::with('activeStatus')
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
    public function getBusinessSectorById($businessSectorId)
    {
        return BusinessSector::with('activeStatus')->where('id',$businessSectorId)
        ->whereNull('deleted_flag')->first();

    }
    public function destroyBusinessSector($businessSectorId)
    {
        return BusinessSector::where('id', $businessSectorId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
