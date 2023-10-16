<?php

namespace App\Http\Repositories\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\DocumentTypeInterface;
use App\Models\DocumentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentTypeRepository implements DocumentTypeInterface
{
    public function index()
    {
        return DocumentType::with('activeStatus')
           
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
    public function getDocumentTypeById($docTypeId)
    {
        return DocumentType::with('activeStatus')->where('id', $docTypeId)
         
            ->whereNull('deleted_flag')->first();
    }
    public function destroyDocumentType($docTypeId)
    {
        return DocumentType::where('id', $docTypeId)->update(['deleted_at' => Carbon::now(), 'deleted_flag' => 1]);
    }
}
