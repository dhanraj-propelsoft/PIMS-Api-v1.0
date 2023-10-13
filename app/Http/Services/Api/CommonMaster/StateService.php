<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Interfaces\Api\CommonMaster\DistrictInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StateService
{
    protected $StateInterface, $CountryInterface;

    public function __construct(StateInterface $StateInterface, CountryInterface $CountryInterface, ActiveStatusInterface $ActiveStatusInterface, DistrictInterface $DistrictInterface)
    {
        $this->StateInterface = $StateInterface;
        $this->CountryInterface = $CountryInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
        $this->DistrictInterface = $DistrictInterface;

    }

    public function index()
    {
        $models = $this->StateInterface->index();

        $entities = $models->map(function ($model) {

            $state = $model->state;
            $description = $model->description;
            $status = $model->activeStatus->active_type;
            $stateId = $model->id;
            $countryId = $model->country->id;
            $countryName = $model->country->country;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'state' => $state, 'description' => $description, 'status' => $status, 'stateId' => $stateId];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForState($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertState($datas);
            $storeModel = $this->StateInterface->store($convert);
            Log::info('StateService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation;
        }

    }
    public function ValidationForState($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {

            if ($field === 'countryId') {
                $rules['countryId'] = ['required', 'integer'];
            } elseif ($field == 'state') {
                $rules['state'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_states', 'state')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        $query->where('country_id', '=', $datas['countryId']);
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

    public function getStateById($stateId)
    {
        $model = $this->StateInterface->getStateById($stateId);
        $country = $this->CountryInterface->getAllCountry();
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $state = $model->state;
            $status = $model->activeStatus->active_type;
            $statusId = $model->pfm_active_status_id;
            $description = $model->description;
            $countryId = $model->country_id;
            $stateId = $model->id;
            $countryName = $model->country->country;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'state' => $state, 'description' => $description, 'statusId' => $statusId, 'stateId' => $stateId, 'status' => $status, 'countries' => $country, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertState($datas)
    {

        if (isset($datas->id)) {
            $model = $this->StateInterface->getStateById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new State();
            $model->created_by = auth()->user()->id;
        }
        $model->state = $datas->state;
        $model->country_id = isset($datas->countryId) ? $datas->countryId : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyStateById($stateId)
    {

        $checkDsitrict = $this->DistrictInterface->checkDistrictForStateId($stateId);
        if (!count($checkDsitrict) == 0) {
            $result = ['type' => 2, 'Message' => 'Failed', 'status' => 'This State Dependent on District'];
        } else {
            $destory = $this->StateInterface->destroyState($stateId);
            if ($destory) {
                $result = ['type' => 1, 'Message' => 'Success', 'status' => 'This State Is Deleted'];
            } else {
                $result = ['type' => 3, 'Message' => 'DestoryFailed'];
            }
        }
        return new SuccessApiResponse($result, 200);
    }
    public function getStateByCountryId($datas)
    {
        $datas = (object) $datas;
        $state =$this->StateInterface->getStateForCountryId($datas->countryId);
        return new SuccessApiResponse($state, 200);

    }
}
