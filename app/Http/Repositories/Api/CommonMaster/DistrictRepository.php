<?php

namespace App\Http\Repositories\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\DistrictInterface;
use App\Models\Area;
use App\Models\District;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DistrictRepository implements DistrictInterface
{
    public function index()
    {
        return District::with('activeStatus', 'state', 'state.country')
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
    public function getDistrictById($districtId)
    {
        return District::with('activeStatus', 'state', 'state.country')->where('id', $districtId)
            ->whereNull('deleted_flag')->first();
    }
    public function destroyDistrict($districtId)
    {
        return District::where('id', $districtId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);

    }
    public function checkDistrictForStateId($stateId)
    {

        return District::where('state_id', $stateId)
            ->whereNull('deleted_flag')->get();
    }
    public function getAllDistrict()
    {
        return District::
            whereNull('deleted_flag')->get();
    }
}
