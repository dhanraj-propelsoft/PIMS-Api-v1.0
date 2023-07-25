<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\CommonCityInterface;
use App\Models\PimsCommonCity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommonCityRepository implements CommonCityInterface
{
    public function index()
    {
        return PimsCommonCity::whereNull('deleted_at')->get();
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
    public function getCityById($id)
    {
        return PimsCommonCity::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyCity($id)
    {
        return PimsCommonCity::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}