<?php

namespace App\Http\Repositories\Api\OrganizationMaster;
use App\Http\Interfaces\Api\OrganizationMaster\OwnerShipInterface;
use App\Models\Organization\OwnerShip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerShipRepository implements OwnerShipInterface
{
    public function index()
    {

        return OwnerShip::with('activeStatus')
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
    public function getOwnerShipById($ownershipId)
    {
        return OwnerShip::with('activeStatus')->where('id',$ownershipId)
        ->whereNull('deleted_flag')->first();

    }
    public function destroyOwnerShip($ownershipId)
    {
        return OwnerShip::where('id', $ownershipId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
