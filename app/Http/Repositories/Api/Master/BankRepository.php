<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\BankInterface;
use App\Models\PimsBank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BankRepository implements BankInterface
{
    public function index()
    {

        return PimsBank::whereNull('deleted_at')->get();
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
        return PimsBank::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyBank($id)
    {
        return PimsBank::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
