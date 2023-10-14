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
        return BankAccountType::with('activeStatus')
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
    public function getBankAccountTypeById($bankAccountId)
    {
        return BankAccountType::with('activeStatus')->where('id', $bankAccountId)
          
            ->whereNull('deleted_flag')->first();

    }
    public function destroyBankAccountType($bankAccountId)
    {
        return BankAccountType::where('id', $bankAccountId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
