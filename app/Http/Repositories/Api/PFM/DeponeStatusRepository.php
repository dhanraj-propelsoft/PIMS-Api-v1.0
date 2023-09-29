<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\DeponeStatusInterface;
use App\Models\DeponeStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeponeStatusRepository implements DeponeStatusInterface
{
    public function index()
    {
        return DeponeStatus::whereNull('deleted_at')->get();
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
    public function getDeponeStatusById($id)
    {
        return DeponeStatus::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyDeponeStatus($id)
    {
        return DeponeStatus::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
