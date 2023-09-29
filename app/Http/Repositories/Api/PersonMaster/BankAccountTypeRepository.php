<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BankAccountTypeInterface;
use App\Models\BankAccountType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BankAccountTypeRepository implements BankAccountTypeInterface
{
    public function index()
    {
        return BankAccountType::where('pfm_active_status_id', 1)
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
    public function getBankAccountTypeById($id)
    {
        return BankAccountType::where(['id'=>$id,'pfm_active_status_id'=>1])
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();

    }
    public function destroyBankAccountType($id)
    {
        return BankAccountType::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}