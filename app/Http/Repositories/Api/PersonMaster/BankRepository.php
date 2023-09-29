<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BankInterface;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BankRepository implements BankInterface
{
    public function index()
    {
        return Bank::where('pfm_active_status_id', 1)
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->get();
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
    public function getBankById($id)
    {
        return Bank::where(['id' => $id, 'pfm_active_status_id' => 1])
            ->whereNull('deleted_at')
            ->whereNull('deleted_flag')->first();
    }
    public function destroyBank($id)
    {
        return Bank::where('id', $id)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
