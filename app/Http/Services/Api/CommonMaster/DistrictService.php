<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CityInterface;
use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Interfaces\Api\CommonMaster\DistrictInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\District;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistrictService
{
    protected $DistrictInterface, $StateInterface;
    public function __construct(DistrictInterface $DistrictInterface, StateInterface $StateInterface, ActiveStatusInterface $ActiveStatusInterface, CountryInterface $CountryInterface, CityInterface $CityInterface)
    {
        $this->DistrictInterface = $DistrictInterface;
        $this->StateInterface = $StateInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
        $this->CountryInterface = $CountryInterface;
        $this->CityInterface = $CityInterface;
    }

    public function index()
    {
        $models = $this->DistrictInterface->index();
        $entities = $models->map(function ($model) {
            $district = $model->district;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $districtId = $model->id;
            $stateId = $model->state->id;
            $stateName = $model->state->state;
            $countryId = $model->state->country->id;
            $countryName = $model->state->country->country;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'stateId' => $stateId, 'stateName' => $stateName, 'district' => $district, 'description' => $description, 'status' => $status, 'districtId' => $districtId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {

        $validation = $this->ValidationForDistrict($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertDistrict($datas);
            $storeModel = $this->DistrictInterface->store($convert);
            Log::info('DistrictService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation;
        }
    }
    public function ValidationForDistrict($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'countryId') {
                $rules['countryId'] = ['required', 'integer'];
            } elseif ($field === 'stateId') {
                $rules['stateId'] = ['required', 'integer'];
            } elseif ($field == 'district') {
                $rules['district'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_districts', 'district')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        $query->where('state_id', '=', $datas['stateId']);
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

    public function getDistrictById($districtId)
    {
        $model = $this->DistrictInterface->getDistrictById($districtId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $country = $this->CountryInterface->getAllCountry();
        $datas = array();
        if ($model) {
            $district = $model->district;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $districtId = $model->id;
            $stateId = $model->state->id;
            $stateName = $model->state->state;
            $countryId = $model->state->country->id;
            $countryName = $model->state->country->country;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'stateId' => $stateId, 'stateName' => $stateName, 'district' => $district, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'districtId' => $districtId, 'country' => $country, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertDistrict($datas)
    {

        if (isset($datas->id)) {
            $model = $this->DistrictInterface->getDistrictById($datas->id);
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

    public function destroyDistrictById($districtId)
    {

        $checkCity = $this->CityInterface->checkCityForDistrictId($districtId);
        if (!count($checkCity) == 0) {
            $result = ['type' => 2, 'Message' => 'Failed', 'status' => 'This District Dependent on City'];
        } else {
            $destory = $this->DistrictInterface->destroyDistrict($districtId);
            if ($destory) {
                $result = ['type' => 1, 'Message' => 'Success', 'status' => 'This District Is Deleted'];
            } else {
                $result = ['type' => 3, 'Message' => 'DestoryFailed'];
            }
        }
        return new SuccessApiResponse($result, 200);
    }
    public function getDistrictByStateId($datas)
    {
        $datas = (object) $datas;
        $state = $this->DistrictInterface->checkDistrictForStateId($datas->stateId);
        return new SuccessApiResponse($state, 200);
    }
}
