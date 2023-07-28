<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\CommonCountryInterface;
use App\Models\PimsCommonCountry;
use App\Models\PimsCommonState;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommonCountryRepository implements CommonCountryInterface
{
    public function index()
    {
        return PimsCommonCountry::whereNull('deleted_at')->get();
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
    public function getCountryById($id)
    {
        return PimsCommonCountry::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyCountry($id)
    {
        try {
            $model = PimsCommonState::where('country_id', $id)->whereNull('deleted_at')->firstOrFail();
            return ['type' => 2, 'message' => 'Failed'];
        } catch (ModelNotFoundException $e) {
            PimsCommonCountry::where('id', $id)->update(['deleted_at' => Carbon::now()]);
            return ['type' => 1, 'message' => 'Success'];
        }
    }
}
