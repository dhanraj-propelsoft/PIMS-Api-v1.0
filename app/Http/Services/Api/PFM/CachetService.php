<?php

namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\CachetInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Cachet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CachetService
{
    protected $CachetInterface;
    public function __construct(CachetInterface $CachetInterface)
    {
        $this->CachetInterface = $CachetInterface;
    }

    public function index()
    {
        $models = $this->CachetInterface->index();
        $entities = $models->map(function ($model) {
            $cachet = $model->cachet;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $datas = ['cachet' => $cachet, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForCachet($datas);
        if ($validation['errors'] !== false) {
            return new ErrorApiResponse($validation['errors'], 400);
        }
        $datas = (object) $datas;
        $convert = $this->convertCachet($datas);
        $storeModel = $this->CachetInterface->store($convert);
        Log::info('CachetService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }

    public function ValidationForCachet($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'cachet') {
                $rules['cachet'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_cachet', 'cachet')->where(function ($query) use ($datas) {
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
    public function getCachetById($id)
    {
        $model = $this->CachetInterface->getCachetById($id);
        $datas = array();
        if ($model) {
            $cachet = $model->cachet;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['cachet' => $cachet, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertCachet($datas)
    {
        if (isset($datas->id)) {
            $model = $this->CachetInterface->getCachetById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Cachet();
            $model->created_by = auth()->user()->id;
        }
        $model->cachet = $datas->cachet;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyCachetById($id)
    {
        $destroy = $this->CachetInterface->destroyCachet($id);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
