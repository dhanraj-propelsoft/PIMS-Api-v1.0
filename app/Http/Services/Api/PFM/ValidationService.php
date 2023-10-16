<?php

namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\ValidationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Validation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidationService
{
    protected $ValidationInterface;
    public function __construct(ValidationInterface $ValidationInterface)
    {
        $this->ValidationInterface = $ValidationInterface;
    }

    public function index()
    {
        $models = $this->ValidationInterface->index();
        $entities = $models->map(function ($model) {
            $validation = $model->validation;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;

            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $datas = ['validation' => $validation, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForValidation($datas);
        if ($validation['errors'] !== false) {
            return new ErrorApiResponse($validation['errors'], 400);
        }
        $datas = (object) $datas;
        $convert = $this->convertValidation($datas);
        $storeModel = $this->ValidationInterface->store($convert);
        Log::info('ValidationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function ValidationForValidation($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'validation') {
                $rules['validation'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_validation', 'validation')->where(function ($query) use ($datas) {
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
    public function getValidationById($id)
    {
        $model = $this->ValidationInterface->getValidationById($id);

        $datas = array();
        if ($model) {
            $validation = $model->validation;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['validation' => $validation, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertValidation($datas)
    {
        if (isset($datas->id)) {
            $model = $this->ValidationInterface->getValidationById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Validation();
            $model->created_by = auth()->user()->id;
        }
        $model->validation = $datas->validation;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyValidationById($id)
    {
        $destroy = $this->ValidationInterface->destroyValidation($id);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
