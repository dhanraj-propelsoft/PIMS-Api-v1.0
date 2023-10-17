<?php

namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessSaleSubsetInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\BusinessSaleSubset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessSaleSubsetService
{
    protected $BusinessSaleSubsetInterface, $ActiveStatusInterface;
    public function __construct(BusinessSaleSubsetInterface $BusinessSaleSubsetInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->BusinessSaleSubsetInterface = $BusinessSaleSubsetInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->BusinessSaleSubsetInterface->index();
        $entities = $models->map(function ($model) {
            $businessSaleSubset = $model->business_sale_subset;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $businessSaleId = $model->id;
            $datas = ['businessSaleSubset' => $businessSaleSubset, 'description' => $description, 'status' => $status, 'businessSaleSubsetId' => $businessSaleId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForBusinessSaleSubset($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertBusinessSaleSubset($datas);
            $storeModel = $this->BusinessSaleSubsetInterface->store($convert);
            Log::info('BusinessSaleSubsetService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation->data['errors'];
        }
    }
    public function ValidationForBusinessSaleSubset($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'businessSaleSubset') {
                $rules['businessSaleSubset'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_business_sale_subsets', 'business_sale_subset')->where(function ($query) use ($datas) {
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
    public function getBusinessSaleSubsetById($businessSaleId)
    {
        $model = $this->BusinessSaleSubsetInterface->getBusinessSaleSubsetById($businessSaleId);
        $activeStatus = $this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $businessSaleSubset = $model->business_sale_subset;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $businessSaleSubsetId = $model->id;
            $datas = ['businessSaleSubset' => $businessSaleSubset, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'businessSaleSubsetId' => $businessSaleSubsetId, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertBusinessSaleSubset($datas)
    {
        if (isset($datas->id)) {
            $model = $this->BusinessSaleSubsetInterface->getBusinessSaleSubsetById(($datas->id));
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new BusinessSaleSubset();
            $model->created_by = auth()->user()->id;
        }
        $model->business_sale_subset = $datas->businessSaleSubset;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBusinessSaleSubsetById($businessSaleId)
    {
        $destroy = $this->BusinessSaleSubsetInterface->destroyBusinessSaleSubset($businessSaleId);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
