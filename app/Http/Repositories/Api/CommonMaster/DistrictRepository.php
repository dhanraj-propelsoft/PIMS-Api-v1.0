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
        return District::where('pfm_active_status_id', 1)
            ->whereNull('deleted_at')
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
    public function getDistrictById($id)
    {
        return District::where(['id' => $id, 'pfm_active_status_id' => 1])
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();
    }
    public function destroyDistrict($id)
    {
        try {
            $model = Area::where('district_id', $id)->whereNull('deleted_at')->firstOrFail();
            return ['type' => 2, 'message' => 'Failed', 'status' => 'This District Dependent on Area'];
        } catch (ModelNotFoundException $e) {
            District::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
            return ['type' => 1, 'message' => 'Success'];
        }
    }
}
