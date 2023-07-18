<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\MaritalStatusInterface;
use App\Models\PimsPersonMaritalStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaritalStatusRepository implements MaritalStatusInterface
{
    public function index()
    {

        return PimsPersonMaritalStatus::whereNull('deleted_at')->get();
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
    public function getMaritalStatusById($id)
    {
        return PimsPersonMaritalStatus::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyMaritalStatus($id)
    {
        return PimsPersonMaritalStatus::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }

}