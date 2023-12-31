<?php

namespace App\Http\Repositories\Api\PFM;

use App\Http\Interfaces\Api\PFM\ValidationInterface;
use App\Models\Validation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ValidationRepository implements ValidationInterface
{
    public function index()
    {
        return Validation::with('activeStatus')->whereNull('deleted_at')->whereNull('deleted_flag')->get();
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
    public function getValidationById($id)
    {
        return Validation::where('id', $id)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();

    }
    public function destroyValidation($id)
    {
        return Validation::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
