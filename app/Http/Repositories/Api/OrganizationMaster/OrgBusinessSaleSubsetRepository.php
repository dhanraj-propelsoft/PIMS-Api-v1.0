<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSaleSubsetInterface;
use App\Models\PimsOrgBusinessSaleSubset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgBusinessSaleSubsetRepository implements OrgBusinessSaleSubsetInterface
{
    public function index()
    {
        return PimsOrgBusinessSaleSubset::whereNull('deleted_at')->get();
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
    public function getOrgBusinessSaleSubsetById($id)
    {
        return PimsOrgBusinessSaleSubset::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgBusinessSaleSubset($id)
    {
        return PimsOrgBusinessSaleSubset::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}