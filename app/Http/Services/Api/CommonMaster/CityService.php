<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CityInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\City;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CityService
{
    protected $CityInterface;
    public function __construct(CityInterface $CityInterface,StateInterface $StateInterface)
    {
        $this->CityInterface = $CityInterface;
        $this->StateInterface = $StateInterface;
    }

    public function index()
    {
        $models = $this->CityInterface->index();
        $state = $this->StateInterface->index();
        $entities = $models->map(function ($model)  use ($state)  {
            $city = $model->city;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $stateId = $model->state_id;
            $id = $model->id;
            $stateData = $state->firstWhere('id',  $model->state_id);
            $stateName = ($stateData) ? $stateData->state : null;
            $datas = ['city' => $city, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'stateName' => $stateName];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertCity($datas);
        $storeModel = $this->CityInterface->store($convert);
        Log::info('CityService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCityById($id )
    {
        $model = $this->CityInterface->getCityById($id);
        $state = $this->StateInterface->index();
        $datas = array();
        if ($model) {
            $city = $model->city;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $stateId = $model->state_id;
            $id = $model->id;
            $stateData = $state->firstWhere('id',  $stateId);
            $stateName = ($stateData) ? $stateData->state : null;
            $datas = ['stateName'=>$stateName,'city' => $city, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'stateId' => $stateId];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCity($datas)
    {
        $model = $this->CityInterface->getCityById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new City();
            $model->created_by=auth()->user()->id;
        }
        $model->city = $datas->city;
        $model->state_id = isset($datas->stateId) ? $datas->stateId : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyCityById($id)
    {
        $destory = $this->CityInterface->destroyCity($id);
        return new SuccessApiResponse($destory, 200);
    }
}