<?php

namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Interfaces\Api\CommonMaster\StateInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StateService
{
    protected $StateInterface, $CountryInterface;

    public function __construct(StateInterface $StateInterface, CountryInterface $CountryInterface)
    {
        $this->StateInterface = $StateInterface;
        $this->CountryInterface = $CountryInterface;
    }

    public function index()
    {
        $models = $this->StateInterface->index();
        $country = $this->CountryInterface->index();
        $entities = $models->map(function ($model) use ($country) {
            $state = $model->state;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $countryId = $model->country_id;
            $countryData = $country->firstWhere('id',  $countryId);
            $countryName = ($countryData) ? $countryData->country : null;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'state' => $state, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'state' => ['required', Rule::unique('pims_com_states', 'state'),],
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();

            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertState($datas);
        $storeModel = $this->StateInterface->store($convert);
        Log::info('StateService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getStateById($id)
    {
        $model = $this->StateInterface->getStateById($id);
        $country = $this->CountryInterface->index();
        $datas = array();
        if ($model) {
            $state = $model->state;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $countryId = $model->country_id;
            $id = $model->id;
            $countryData = $country->firstWhere('id',  $countryId);
            $countryName = ($countryData) ? $countryData->country : null;
            $datas = ['countryId' => $countryId, 'countryName' => $countryName, 'state' => $state, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertState($datas)
    {
        $model = $this->StateInterface->getStateById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
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

    public function destroyStateById($id)
    {
        $destory = $this->StateInterface->destroyState($id);
        return new SuccessApiResponse($destory, 200);
    }
}
