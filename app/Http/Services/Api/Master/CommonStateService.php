<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\CommonCountryInterface;
use App\Http\Interfaces\Api\Master\CommonStateInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsCommonState;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommonStateService
{
    protected $CommonStateInterface;
    public function __construct(CommonStateInterface $CommonStateInterface, CommonCountryInterface $CommonCountryInterface)
    {
        $this->CommonStateInterface = $CommonStateInterface;
        $this->CommonCountryInterface = $CommonCountryInterface;
    }

    public function index()
    {
        $models = $this->CommonStateInterface->index();
        $country = $this->CommonCountryInterface->index();
        $entities = $models->map(function ($model) use ($country) {
            $state = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $countryData = $country->firstWhere('id',  $model->country_id);
            $country_name = ($countryData) ? $countryData->name : 'Null';
            $datas = [
                'state' => $state,
                'status' => $status,
                'activeStatus' => $activeStatus,
                'id' => $id,
                'country_name' => $country_name,
            ];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'state' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();

            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertState($datas);
        $storeModel = $this->CommonStateInterface->store($convert);
        Log::info('CommonStateService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getStateById($id)
    {
        $model = $this->CommonStateInterface->getStateById($id);
        $country = $this->CommonCountryInterface->index();
        $datas = array();
        if ($model) {
            $state = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $country_id=$model->country_id;
            $id = $model->id;
            $countryData = $country->firstWhere('id',  $country_id);
            $country_name = ($countryData) ? $countryData->name : 'Null';
            $datas = ['country_id'=>$country_id, 'state' => $state, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'country_name' => $country_name];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertState($datas)
    {
        $model = $this->CommonStateInterface->getStateById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsCommonState();
        }
        $model->name = $datas->state;
        $model->country_id = isset($datas->country_id) ? $datas->country_id: null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyStateById($id)
    {
        $destory = $this->CommonStateInterface->destroyState($id);
        return new SuccessApiResponse($destory, 200);
    }
}
