<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\CommonCityInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsCommonCity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommonCityService
{
    protected $CommonCityInterface;
    public function __construct(CommonCityInterface $CommonCityInterface)
    {
        $this->CommonCityInterface = $CommonCityInterface;
    }

    public function index()
    {
        $models = $this->CommonCityInterface->index();
        $entities = $models->map(function ($model) {
            $city = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $stateId = $model->state_id;
            $id = $model->id;
            $datas = ['city' => $city, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'stateId' => $stateId];
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
        $storeModel = $this->CommonCityInterface->store($convert);
        Log::info('CommonCityService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCityById($id = null)
    {
        $model = $this->CommonCityInterface->getCityById($id);
        $datas = array();
        if ($model) {
            $city = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $stateId = $model->state_id;
            $id = $model->id;
            $datas = ['city' => $city, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'stateId' => $stateId];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCity($datas)
    {
        $model = $this->CommonCityInterface->getCityById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsCommonCity();
        }
        $model->name = $datas->city;
        $model->state_id = isset($datas->stateId) ? $datas->stateId : null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyCityById($id)
    {
        $destory = $this->CommonCityInterface->destroyCity($id);
        return new SuccessApiResponse($destory, 200);
    }
}