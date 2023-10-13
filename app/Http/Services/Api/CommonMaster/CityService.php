<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CityInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Interfaces\Api\CommonMaster\AreaInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\City;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CityService
{
    protected $CityInterface, $StateInterface;

    public function __construct(CityInterface $CityInterface, StateInterface $StateInterface,ActiveStatusInterface $ActiveStatusInterface,CountryInterface $CountryInterface,AreaInterface $AreaInterface)
    {
        $this->CityInterface = $CityInterface;
        $this->StateInterface = $StateInterface;
        $this->ActiveStatusInterface=$ActiveStatusInterface;
        $this->CountryInterface=$CountryInterface;
        $this->AreaInterface=$AreaInterface;
    }

    public function index()
    {
        $models = $this->CityInterface->index();

        $entities = $models->map(function ($model) {
            $city = $model->city;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $districtId = $model->district->id;
            $districtName = $model->district->district;
            $cityId = $model->id;
            $stateId = $model->district->state->id;
            $stateName = $model->district->state->state;
            $countryId = $model->district->state->country->id;
            $countryName = $model->district->state->country->country;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'stateId' => $stateId, 'stateName' => $stateName, 'districtId' => $districtId, 'districtName' => $districtName, 'city' => $city, 'description' => $description, 'status' => $status, 'cityId' => $cityId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForCity($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertCity($datas);
            $storeModel = $this->CityInterface->store($convert);
            Log::info('CityService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation;
        }
    }
    public function ValidationForCity($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'countryId') {
                $rules['countryId'] = ['required', 'integer'];
            } elseif ($field === 'stateId') {
                $rules['stateId'] = ['required', 'integer'];
            } elseif ($field === 'districtId') {
                $rules['districtId'] = ['required', 'integer'];
            } elseif ($field == 'city') {
                $rules['city'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_cities', 'city')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        $query->where('district_id', '=', $datas['districtId']);
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];
            }

        }
        $validator = Validator::make($datas, $rules);
        if ($validator->fails()) {

            $resStatus = ['errors' => $validator->errors()];
            $resCode = 400;

        } else {

            $resStatus = ['errors' => false];
            $resCode = 200;

        }
        return new SuccessApiResponse($resStatus, $resCode);
    }

    public function getCityById($CityId)
    {
        $model = $this->CityInterface->getCityById($CityId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $country = $this->CountryInterface->getAllCountry();
      
        $datas = array();
        if ($model) {
            $city = $model->city;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $cityId = $model->id;
            $stateId = $model->district->state->id;
            $stateName = $model->district->state->state;
            $countryId = $model->district->state->country->id;
            $countryName = $model->district->state->country->country;
            $districtId = $model->district->id;
            $districtName = $model->district->district;
          
            $datas = ['countryId'=>$countryId,'countryName'=>$countryName,'stateId' => $stateId, 'stateName' => $stateName,'districtId'=>$districtId,'districtName'=>$districtName, 'city' => $city, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'cityId' => $cityId,'country'=>$country,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertCity($datas)
    {

        if (isset($datas->id)) {
            $model = $this->CityInterface->getCityById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new City();
            $model->created_by = auth()->user()->id;
        }
        $model->city = $datas->city;
        $model->district_id = isset($datas->districtId) ? $datas->districtId : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyCityById($cityId)
    {
        $checkArea = $this->AreaInterface->checkAreaForCityId($cityId);
     
        if (!count($checkArea) == 0) {
            $result = ['type' => 2, 'Message' => 'Failed', 'status' => 'This City Dependent on Area'];
        } else {
            $destory = $this->CityInterface->destroyCity($cityId);
            if ($destory) {
                $result = ['type' => 1, 'Message' => 'Success', 'status' => 'This City Is Deleted'];
            } else {
                $result = ['type' => 3, 'Message' => 'DestoryFailed'];
            }
        }
        return new SuccessApiResponse($result, 200);
    }
    public function getCityByDistrictId($datas)
    {
        $datas = (object) $datas;
        $state =$this->CityInterface->checkCityForDistrictId($datas->districtId);
        return new SuccessApiResponse($state, 200);
    }
}
