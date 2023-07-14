<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\GenderInterface;
use App\Models\PimsPersonGender;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenderRepository implements GenderInterface
{
    public function index()
    {
        return PimsPersonGender::whereNull('deleted_at')->get();
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
    public function getGenderById($id)
    {
        return PimsPersonGender::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyGender($id)
    {
        return PimsPersonGender::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
