<?php

namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\ExistenceInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Existence;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExistenceService
{
    protected $ExistenceInterface;
    public function __construct(ExistenceInterface $ExistenceInterface)
    {
        $this->ExistenceInterface = $ExistenceInterface;
    }

    public function index()
    {
        $models = $this->ExistenceInterface->index();
        $entities = $models->map(function ($model) {
            $existence = $model->existence;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;

            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;

            $datas = ['existence' => $existence, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForExistence($datas);
        if ($validation['errors'] !== false) {
            return new ErrorApiResponse($validation['errors'], 400);
        }
        $datas = (object) $datas;
        $convert = $this->convertExistence($datas);
        $storeModel = $this->ExistenceInterface->store($convert);
        Log::info('ExistenceService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }

    public function ValidationForExistence($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'existence') {
                $rules['existence'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_existence', 'existence')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];
            }
        }
        $validator = Validator::make($datas, $rules);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }
        return ['errors' => false, 'status_code' => 200,];
    }
    public function getExistenceById($id)
    {
        $model = $this->ExistenceInterface->getExistenceById($id);
        $datas = array();
        if ($model) {
            $existence = $model->existence;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['existence' => $existence, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertExistence($datas)
    {
        if (isset($datas->id)) {
            $model = $this->ExistenceInterface->getExistenceById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Existence();
            $model->created_by = auth()->user()->id;
        }
        $model->existence = $datas->existence;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyExistenceById($id)
    {
        $destroy = $this->ExistenceInterface->destroyExistence($id);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
