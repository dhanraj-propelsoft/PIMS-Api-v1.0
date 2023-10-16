<?php

namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\OriginInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Origin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OriginService
{
    protected $OriginInterface;
    public function __construct(OriginInterface $OriginInterface)
    {
        $this->OriginInterface = $OriginInterface;
    }

    public function index()
    {
        $models = $this->OriginInterface->index();

        $entities = $models->map(function ($model) {

            $origin = $model->origin;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;

            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $datas = ['origin' => $origin, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForOrigin($datas);
        if ($validation['errors'] !== false) {
            return new ErrorApiResponse($validation['errors'], 400);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrigin($datas);
        $storeModel = $this->OriginInterface->store($convert);
        Log::info('OriginService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function ValidationForOrigin($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'origin') {
                $rules['origin'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_origin', 'origin')->where(function ($query) use ($datas) {
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
    public function getOriginById($id)
    {
        $model = $this->OriginInterface->getOriginById($id);
        $datas = array();
        if ($model) {
            $origin = $model->origin;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['origin' => $origin, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertOrigin($datas)
    {
        if (isset($datas->id)) {
            $model = $this->OriginInterface->getOriginById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Origin();
            $model->created_by = auth()->user()->id;
        }
        $model->origin = $datas->origin;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyOriginById($id)
    {
        $destroy = $this->OriginInterface->destroyOrigin($id);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
