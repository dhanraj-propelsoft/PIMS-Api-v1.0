<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgDocumentTypeInterface;
use App\Models\PimsOrgDocumentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrgDocumentTypeRepository implements OrgDocumentTypeInterface
{
    public function index()
    {

        return PimsOrgDocumentType::whereNull('deleted_at')->get();
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
    public function getOrgDocumentTypeById($id)
    {
        return PimsOrgDocumentType::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyOrgDocumentType($id)
    {
        return PimsOrgDocumentType::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}