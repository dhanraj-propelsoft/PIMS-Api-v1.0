<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\PersonStageInterface;
use App\Models\PersonStage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PersonStageRepository implements PersonStageInterface
{
    public function index()
    {
        return PersonStage::
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
    public function getPersonStageById($id)
    {
        return PersonStage::where('id', $id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();
    }
    public function destroyPersonStage($id)
    {
        return PersonStage::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
