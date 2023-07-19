<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\RelationShipInterface;
use App\Models\PimsPersonRelationShip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelationShipRepository implements RelationShipInterface
{
    public function index()
    {
        return PimsPersonRelationShip::whereNull('deleted_at')->get();
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
    public function getRelationShipById($id)
    {
        return PimsPersonRelationShip::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyRelationShip($id)
    {
        return PimsPersonRelationShip::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }

}
