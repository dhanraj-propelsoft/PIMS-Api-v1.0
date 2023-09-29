<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\salutationInterface;
use App\Models\Salutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalutationRepository implements salutationInterface
{
    public function index()
    {
        return Salutation::where('pfm_active_status_id', 1)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')
        ->get();
    }
    public function store($model)
    {

        try {
            $result = DB::transaction(function () use ($model) {
                $model->save();

                return [
                    'message' => 'Success',
                    'data' => $model,
                ];
            });

            return $result;
        } catch (\Exception $e) {
            return [
                'message' => 'Failed',
                'data' => $e,
            ];
        }
    }
    public function getSalutationById($id)
    {
        return Salutation::where(['id'=>$id,'pfm_active_status_id'=>1])
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();

    }
    public function destroySalutation($id)
    {
        return Salutation::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
