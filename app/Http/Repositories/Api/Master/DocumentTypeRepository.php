<?php

namespace App\Http\Repositories\Api\Master;

use App\Http\Interfaces\Api\Master\DocumentTypeInterface;
use App\Models\PimsPersonDocumentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentTypeRepository implements DocumentTypeInterface
{
    public function index()
    {
        return PimsPersonDocumentType::whereNull('deleted_at')->get();
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
        return PimsPersonDocumentType::where('id', $id)->whereNull('deleted_at')->first();

    }
    public function destroyDocumentType($id)
    {
        return PimsPersonDocumentType::where('id', $id)->update(['deleted_at' => Carbon::now()]);
    }
}