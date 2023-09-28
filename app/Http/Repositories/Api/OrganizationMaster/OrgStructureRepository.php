<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgStructureInterface;
use App\Models\PimsOrgStructure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgStructureRepository implements OrgStructureInterface
{
    public function index()
    {

        return PimsOrgStructure::whereNull('deleted_at')->get();
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
    public function getOrgStructureById($id)
    {
        return PimsOrgStructure::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgStructure($id)
    {
        return PimsOrgStructure::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}
