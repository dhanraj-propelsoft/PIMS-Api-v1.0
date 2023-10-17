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

        return Structure::with('activeStatus')
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
    public function getStructureById($structureId)
    {
        return Structure::with('activeStatus')->where('id',$structureId)
        ->whereNull('deleted_flag')->first();
    }
    public function destroyStructure($structureId)
    {
        return Structure::where('id', $structureId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}
