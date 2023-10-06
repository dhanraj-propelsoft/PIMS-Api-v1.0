<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\DistrictInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\District;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistrictService
{
    protected $DistrictInterface, $StateInterface;
    public function __construct(DistrictInterface $DistrictInterface, StateInterface $StateInterface)
    {
        $this->DistrictInterface = $DistrictInterface;
        $this->StateInterface = $StateInterface;
    }

    public function index()
    {

        $models = $this->DistrictInterface->index();
        $state = $this->StateInterface->index();
        $entities = $models->map(function ($model) use ($state) {
            $district = $model->district;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $stateId = $model->state_id;
            $stateData = $state->firstWhere('id', $stateId);
            $stateName = ($stateData) ? $stateData->state : null;
            $datas = ['stateId' => $stateId, 'stateName' => $stateName, 'district' => $district, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {

        $validator = Validator::make($datas, [
            'district' => ['required', Rule::unique('pims_com_districts', 'district'),],
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertDistrict($datas);
        $storeModel = $this->DistrictInterface->store($convert);
        Log::info('DistrictService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getDistrictById($id)
    {
        $model = $this->DistrictInterface->getDistrictById($id);
        $state = $this->StateInterface->index();
        $datas = array();
        if ($model) {
            $district = $model->district;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $stateId = $model->state_id;
            $description = $model->description;
            $id = $model->id;
            $stateData = $state->firstWhere('id', $stateId);
            $stateName = ($stateData) ? $stateData->state : null;
            $datas = ['stateId' => $stateId, 'stateName' => $stateName, 'district' => $district, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertDistrict($datas)
    {
        $model = $this->DistrictInterface->getDistrictById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new District();
            $model->created_by = auth()->user()->id;
        }
        $model->district = $datas->district;
        $model->state_id = isset($datas->stateId) ? $datas->stateId : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;

        return $model;
    }

    public function destroyDistrictById($id)
    {
        $destory = $this->DistrictInterface->destroyDistrict($id);
        return new SuccessApiResponse($destory, 200);
    }
}
