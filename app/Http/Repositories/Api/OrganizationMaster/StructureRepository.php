<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\StructureInterface;
use App\Models\Organization\Structure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StructureRepository implements StructureInterface
{
    public function index()
    {

        return Structure::where('pfm_active_status_id', 1)
        ->whereNull('deleted_at')
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
    public function getStructureById($id)
    {
        return Structure::where(['id'=>$id,'pfm_active_status_id'=>1])
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();
    }
    public function destroyStructure($id)
    {
        return Structure::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
