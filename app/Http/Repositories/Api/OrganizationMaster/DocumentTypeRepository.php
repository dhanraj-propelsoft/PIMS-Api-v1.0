<?php

namespace App\Http\Repositories\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\DocumentTypeInterface;
use App\Models\Organization\DocumentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentTypeRepository implements DocumentTypeInterface
{
    public function index()
    {

        return DocumentType::
        whereNull('deleted_at')
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
    public function getDocumentTypeById($id)
    {
        return DocumentType::where('id',$id)
        ->whereNull('deleted_at')
        ->whereNull('deleted_flag')->first();

    }
    public function destroyDocumentType($id)
    {
        return DocumentType::where('id', $id)->update(['deleted_at' => Carbon::now(),'deleted_flag'=>1]);
    }
}