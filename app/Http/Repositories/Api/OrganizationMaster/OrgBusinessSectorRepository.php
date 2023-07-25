<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSectorInterface;
use App\Models\PimsOrgBusinessSector;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgBusinessSectorRepository implements OrgBusinessSectorInterface
{
    public function index()
    {

        return PimsOrgBusinessSector::whereNull('deleted_at')->get();
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
    public function getOrgBusinessSectorById($id)
    {
        return PimsOrgBusinessSector::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgBusinessSector($id)
    {
        return PimsOrgBusinessSector::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}