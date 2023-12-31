<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\RelationShipInterface;
use App\Models\RelationShip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelationShipRepository implements RelationShipInterface
{
    public function index()
    {
        return RelationShip::with('activeStatus')
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
    public function getRelationShipById($relationshipId)
    {
        return RelationShip::with('activeStatus')->where('id',$relationshipId)
            ->whereNull('deleted_flag')->first();

    }
    public function destroyRelationShip($relationshipId)
    {
        return RelationShip::where('id', $relationshipId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }

}
