<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\AreaInterface;
use App\Http\Interfaces\Api\CommonMaster\CityInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Area;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AreaService
{
    protected $AreaInterface, $CityInterface;
    public function __construct(AreaInterface $AreaInterface, CityInterface $CityInterface,CountryInterface $CountryInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->AreaInterface = $AreaInterface;
        $this->CityInterface = $CityInterface;
        $this->CountryInterface=$CountryInterface;
        $this->ActiveStatusInterface=$ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->AreaInterface->index();
        $entities = $models->map(function ($model) {
            $area = $model->area;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $pinCode = $model->pin_code;
            $areaId = $model->id;
            $stateId = $model->city->district->state->id;
            $stateName = $model->city->district->state->state;
            $countryId = $model->city->district->state->country->id;
            $countryName = $model->city->district->state->country->country;
            $districtId = $model->city->district->id;
            $districtName = $model->city->district->district;
            $cityId = $model->city->id;
            $cityName = $model->city->city;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'stateId' => $stateId, 'stateName' => $stateName, 'districtId' => $districtId, 'districtName' => $districtName, 'cityId' => $cityId, 'cityName' => $cityName, 'area' => $area, 'pinCode' => $pinCode, 'description' => $description, 'status' => $status, 'areaId' => $areaId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {

        $validation = $this->ValidationForArea($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertArea($datas);
            $storeModel = $this->AreaInterface->store($convert);
            Log::info('AreaService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation;
        }
    }
    public function ValidationForArea($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'countryId') {
                $rules['countryId'] = ['required', 'integer'];
            } elseif ($field === 'stateId') {
                $rules['stateId'] = ['required', 'integer'];
            } elseif ($field === 'districtId') {
                $rules['districtId'] = ['required', 'integer'];
            } elseif ($field === 'cityId') {
                $rules['cityId'] = ['required', 'integer'];
            }elseif ($field === 'pinCode') {
                $rules['pinCode'] = [
                    'required',
                    'integer',
                    Rule::unique('pims_com_area', 'pin_code')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        $query->where('city_id', '=', $datas['cityId']);
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];                
            }
             elseif ($field == 'area') {
                $rules['area'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_area', 'area')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        $query->where('city_id', '=', $datas['cityId']);
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
    public function getAreaById($areaId)
    {
        $model = $this->AreaInterface->getAreaById($areaId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $country = $this->CountryInterface->getAllCountry();
        $datas = array();
        if ($model) {
            $area = $model->area;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $pinCode = $model->pin_code;
            $areaId = $model->id;
            $stateId = $model->city->district->state->id;
            $stateName = $model->city->district->state->state;
            $countryId = $model->city->district->state->country->id;
            $countryName = $model->city->district->state->country->country;
            $districtId = $model->city->district->id;
            $districtName = $model->city->district->district;
            $cityId = $model->city->id;
            $cityName = $model->city->city;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'stateId' => $stateId, 'stateName' => $stateName, 'districtId' => $districtId, 'districtName' => $districtName, 'cityId' => $cityId, 'cityName' => $cityName, 'area' => $area, 'pinCode' => $pinCode, 'description' => $description, 'status' => $status, 'areaId' => $areaId,'activeStatusId'=>$activeStatusId,'activeStatus'=>$activeStatus,'country'=>$country];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertArea($datas)
    {

        if (isset($datas->id)) {
            $model = $this->AreaInterface->getAreaById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Area();
            $model->created_by = auth()->user()->id;
        }
        $model->area = $datas->area;
        $model->pin_code = $datas->pinCode;
        $model->city_id = isset($datas->cityId) ? $datas->cityId : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;

        return $model;
    }

    public function destroyAreaById($areaId)
    {
        
        $destory = $this->AreaInterface->destroyArea($areaId);
        return new SuccessApiResponse($destory, 200);
        
    }
    public function getAreaByCityId($datas)
    {
        $datas = (object) $datas;
        $state =$this->AreaInterface->checkAreaForCityId($datas->cityId);
        return new SuccessApiResponse($state, 200);
    }
}
