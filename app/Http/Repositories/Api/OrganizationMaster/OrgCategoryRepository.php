<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgCategoryInterface;
use App\Models\PimsOrgCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgCategoryRepository implements OrgCategoryInterface
{
    public function index()
    {

        return PimsOrgCategory::whereNull('deleted_at')->get();
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
    public function getOrgCategoryById($id)
    {
        return PimsOrgCategory::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgCategory($id)
    {
        return PimsOrgCategory::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}