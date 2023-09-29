<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\SurvivalInterface;
use App\Models\Survival;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SurvivalRepository implements SurvivalInterface
{
    public function index()
    {
        return Survival::whereNull('deleted_at')->get();
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
    public function getSurvivalById($id)
    {
        return Survival::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroySurvival($id)
    {
        return Survival::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
