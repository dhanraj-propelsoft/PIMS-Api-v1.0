<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\BloodGroupInterface;
use App\Models\PimsPersonBloodGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BloodGroupRepository implements BloodGroupInterface
{
    public function index()
    {

        return PimsPersonBloodGroup::whereNull('deleted_at')->get();
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
        return PimsPersonBloodGroup::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyBloodGroup($id)
    {
        return PimsPersonBloodGroup::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }

}
