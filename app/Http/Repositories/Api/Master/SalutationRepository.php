<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\salutationInterface;
use App\Models\PimsPersonSalutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalutationRepository implements salutationInterface
{
    public function index()
    {
        return PimsPersonSalutation::whereNull('deleted_at')->get();
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
    public function getSalutationById($id)
    {
        return PimsPersonSalutation::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroySalutation($id)
    {
        return PimsPersonSalutation::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
