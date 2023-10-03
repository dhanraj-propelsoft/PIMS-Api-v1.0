<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BloodGroupInterface;
use App\Models\BloodGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BloodGroupRepository implements BloodGroupInterface
{
    public function index()
    {

        return BloodGroup::
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
    public function getBloodGroupById($id)
    {
        return BloodGroup::where('id', $id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();

    }
    public function destroyBloodGroup($id)
    {
        return BloodGroup::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }

}
