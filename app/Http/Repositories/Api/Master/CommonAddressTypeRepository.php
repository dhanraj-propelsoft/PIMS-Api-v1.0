<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\CommonAddressTypeInterface;
use App\Models\PimsCommonAddressType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CommonAddressTypeRepository implements CommonAddressTypeInterface
{
    public function index()
    {
        return PimsCommonAddressType::whereNull('deleted_at')->get();
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
    public function getCommonAddressTypeById($id)
    {
        return PimsCommonAddressType::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyCommonAddressType($id)
    {
        return PimsCommonAddressType::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}