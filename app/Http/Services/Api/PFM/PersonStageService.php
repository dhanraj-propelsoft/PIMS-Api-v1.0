<?php

namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\PersonStageInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PersonStage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PersonStageService
{
    protected $PersonStageInterface;
    public function __construct(PersonStageInterface $PersonStageInterface)
    {
        $this->PersonStageInterface = $PersonStageInterface;
    }

    public function index()
    {
        $models = $this->PersonStageInterface->index();
        $entities = $models->map(function ($model) {
            $personStage = $model->person_stage;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $datas = ['personStage' => $personStage, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForPersonStage($datas);
        if ($validation['errors'] !== false) {
            return new ErrorApiResponse($validation['errors'], 400);
        }
        $datas = (object) $datas;
        $convert = $this->convertPersonStage($datas);
        $storeModel = $this->PersonStageInterface->store($convert);
        Log::info('PersonStageService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function ValidationForPersonStage($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'personStage') {
                $rules['personStage'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_person_stage', 'person_stage')->where(function ($query) use ($datas) {
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
    public function getPersonStageById($id)
    {
        $model = $this->PersonStageInterface->getPersonStageById($id);
        $datas = array();
        if ($model) {
            $personStage = $model->person_stage;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['personStage' => $personStage, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertPersonStage($datas)
    {
        if (isset($datas->id)) {
            $model = $this->PersonStageInterface->getPersonStageById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new PersonStage();
            $model->created_by = auth()->user()->id;
        }
        $model->person_stage = $datas->personStage;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyPersonStageById($id)
    {
        $destroy = $this->PersonStageInterface->destroyPersonStage($id);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
