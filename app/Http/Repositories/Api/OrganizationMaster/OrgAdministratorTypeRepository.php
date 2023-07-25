<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgAdministratorTypeInterface;
use App\Models\PimsOrgAdministratorType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgAdministratorTypeRepository implements OrgAdministratorTypeInterface
{
    public function index()
    {
        return PimsOrgAdministratorType::whereNull('deleted_at')->get();
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
    public function getOrgAdministratorTypeById($id)
    {
        return PimsOrgAdministratorType::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgAdministratorType($id)
    {
        return PimsOrgAdministratorType::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}