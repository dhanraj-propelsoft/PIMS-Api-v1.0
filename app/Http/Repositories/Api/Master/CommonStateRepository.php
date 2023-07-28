<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\CommonStateInterface;
use App\Models\PimsCommonState;
use App\Models\PimsCommonCity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommonStateRepository implements CommonStateInterface
{
    public function index()
    {
        return PimsCommonState::whereNull('deleted_at')->get();
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
    public function getStateById($id)
    {
        return PimsCommonState::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyState($id)
    {
        try {
            $model = PimsCommonCity::where('state_id', $id)->whereNull('deleted_at')->firstOrFail();
            return ['type' => 2, 'message' => 'Failed'];
        } catch (ModelNotFoundException $e) {
            PimsCommonState::where('id', $id)->update(['deleted_at' => Carbon::now()]);
            return ['type' => 1, 'message' => 'Success'];
        }
    }
}