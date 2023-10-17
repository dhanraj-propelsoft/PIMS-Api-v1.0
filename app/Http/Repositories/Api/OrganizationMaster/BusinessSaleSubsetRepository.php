<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessSaleSubsetInterface;
use App\Models\Organization\BusinessSaleSubset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BusinessSaleSubsetRepository implements BusinessSaleSubsetInterface
{
    public function index()
    {
        return BusinessSaleSubset::with('activeStatus')
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
    public function getBusinessSaleSubsetById($businessSaleId)
    {
        return BusinessSaleSubset::with('activeStatus')->where('id',$businessSaleId)
            ->whereNull('deleted_flag')->first();

    }
    public function destroyBusinessSaleSubset($businessSaleId)
    {
        return BusinessSaleSubset::where('id', $businessSaleId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
