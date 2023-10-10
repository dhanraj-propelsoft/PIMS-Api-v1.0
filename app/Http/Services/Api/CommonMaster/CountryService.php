<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Country;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CountryService
{
    protected $CountryInterface, $StateInterface, $ActiveStatusInterface;
    public function __construct(CountryInterface $CountryInterface, StateInterface $StateInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->CountryInterface = $CountryInterface;
        $this->StateInterface = $StateInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {

        $models = $this->CountryInterface->index();
        $entities = $models->map(function ($model) {
            $country = $model->country;
            $numericCode = $model->numeric_code;
            $phoneCode = $model->phone_code;
            $capital = $model->capital;
            $flag = $model->flag;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $status = $this->ActiveStatusInterface->getActiveStatusById($activeStatusId);

            $currentStatusName = ($status) ? ($status->active_type) : "";

            $datas = ['country' => $country, 'numericCode' => $numericCode, 'flag' => $flag, 'capital' => $capital, 'phoneCode' => $phoneCode, 'description' => $description, 'currentStatusName' => $currentStatusName, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForCountry($datas);
        if (!$validation) {
            $datas = (object) $datas;
            $convert = $this->convertCountry($datas);
            $storeModel = $this->CountryInterface->store($convert);
            Log::info('CountryService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation;
        }
    }

    public function ValidationForCountry($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'country') {
                $rules['country'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_countries', 'country')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];
            } elseif ($field === 'numericCode' && $value !== null) {
                $rules['numericCode'] = [
                    Rule::unique('pims_com_countries', 'numeric_code')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];
            } elseif ($field === 'phoneCode' && $value !== null) {
                $rules['phoneCode'] = [
                    Rule::unique('pims_com_countries', 'phone_code')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];
            } elseif ($field === 'capital' && $value !== null) {
                $rules['capital'] = [
                    Rule::unique('pims_com_countries', 'capital')->where(function ($query) use ($datas) {
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

            $resStatus = ['errors' => $validator->errors()];
            $resCode = 400;
        } else {

            $resStatus = ['errors' => false];
            $resCode = 200;
        }
        return new SuccessApiResponse($resStatus, $resCode);
    }
    public function getCountryById($id)
    {
        $model = $this->CountryInterface->getCountryById($id);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $country = $model->country;
            $activeStatusId = $model->pfm_active_status_id;
            $numericCode = $model->numeric_code;
            $phoneCode = $model->phone_code;
            $capital = $model->capital;
            $flag = $model->flag;
            $description = $model->description;
            $id = $model->id;
            $datas = ['country' => $country, 'numericCode' => $numericCode, 'flag' => $flag, 'capital' => $capital, 'phoneCode' => $phoneCode, 'description' => $description, 'activeStatusId' => $activeStatusId, 'id' => $id, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertCountry($datas)
    {
        if (isset($datas->id)) {
            $model = $this->CountryInterface->getCountryById($datas->id);
            $model->id = $datas->id;
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Country();
            $model->created_by = auth()->user()->id;
        }
        $model->country = $datas->country;
        $model->numeric_code = isset($datas->numericCode) ? $datas->numericCode : null;
        $model->phone_code = isset($datas->phoneCode) ? $datas->phoneCode : null;
        $model->capital = isset($datas->capital) ? $datas->capital : null;
        $model->flag = isset($datas->flag) ? $datas->flag : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;

        return $model;
    }

    public function destroyCountryById($id)
    {
        $checkState = $this->StateInterface->getStateById($id);
        if ($checkState) {
            $result = ['type' => 2, 'Message' => 'Failed', 'status' => 'This Country Dependent on State'];
        } else {
            $destory = $this->CountryInterface->destroyCountry($id);
            if ($destory) {
                $result = ['type' => 1, 'Message' => 'Success', 'status' => 'This Country Is Deleted'];
            } else {
                $result = ['type' => 3, 'Message' => 'DestoryFailed'];
            }
        }
        return new SuccessApiResponse($result, 200);
    }
}
