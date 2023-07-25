<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgOwnerShipInterface;
use App\Models\PimsOrgOwnerShip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgOwnerShipRepository implements OrgOwnerShipInterface
{
    public function index()
    {

        return PimsOrgOwnerShip::whereNull('deleted_at')->get();
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
    public function getOrgOwnerShipById($id)
    {
        return PimsOrgOwnerShip::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgOwnerShip($id)
    {
        return PimsOrgOwnerShip::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}