<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Models\ActiveStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActiveStatusRepository implements ActiveStatusInterface
{
    public function index()
    {
        return ActiveStatus::whereNull('deleted_at')->get();
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
    public function getActiveStatusById($id)
    {
        return ActiveStatus::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyActiveStatus($id)
    {
        return ActiveStatus::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
