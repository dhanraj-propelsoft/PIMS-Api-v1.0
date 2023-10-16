<?php

namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\ActiveStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ActiveStatusService
{
    protected $ActiveStatusInterface;
    public function __construct(ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->ActiveStatusInterface->index();
        $entities = $models->map(function ($model) {
            $activeType = $model->active_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['activeType' => $activeType, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForActiveStatus($datas);
        if ($validation['errors'] !== false) {
            return new ErrorApiResponse($validation['errors'], 400);
        }
        $datas = (object) $datas;
        $convert = $this->convertActiveStatus($datas);
        $storeModel = $this->ActiveStatusInterface->store($convert);
        Log::info('ActiveStatusService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function ValidationForActiveStatus($datas)
    {
        $rules = [];
        foreach ($datas as $field => $value) {
            if ($field === 'activeType') {
                $rules['activeType'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_active_status', 'active_type')->where(function ($query) use ($datas) {
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
    public function getActiveStatusById($id)
    {
        $model = $this->ActiveStatusInterface->getActiveStatusById($id);
        $datas = array();
        if ($model) {
            $activeType = $model->active_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['activeType' => $activeType, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertActiveStatus($datas)
    {
        if (isset($datas->id)) {
            $model = $this->ActiveStatusInterface->getActiveStatusById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new ActiveStatus();
            $model->created_by = auth()->user()->id;
        }
        $model->active_type = $datas->activeType;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->active_status = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyActiveStatusById($id)
    {
        $destroy = $this->ActiveStatusInterface->destroyActiveStatus($id);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
