<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\GenderInterface;
use App\Models\Gender;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenderRepository implements GenderInterface
{
    public function index()
    {
        return Gender::
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
    public function getGenderById($id)
    {
        return Gender::where('id',$id)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();

    }
    public function destroyGender($id)
    {
        return Gender::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag' => 1]);
    }
}
