<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\AdministratorTypeInterface;
use App\Models\Organization\AdministratorType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdministratorTypeRepository implements AdministratorTypeInterface
{
    public function index()
    {
        return  AdministratorType::with('activeStatus')
      
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
    public function getAdministratorTypeById($adminTypeId)
    {
        return  AdministratorType::with('activeStatus')->where('id',$adminTypeId)
        ->whereNull('deleted_flag')->first();

    }
    public function destroyAdministratorType($adminTypeId)
    {
        return  AdministratorType::where('id', $adminTypeId)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}