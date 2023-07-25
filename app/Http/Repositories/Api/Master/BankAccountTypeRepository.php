<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\BankAccountTypeInterface;
use App\Models\PimsBankAccountType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BankAccountTypeRepository implements BankAccountTypeInterface
{
    public function index()
    {
        return PimsBankAccountType::whereNull('deleted_at')->get();
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
        return PimsBankAccountType::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyBankAccountType($id)
    {
        return PimsBankAccountType::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}