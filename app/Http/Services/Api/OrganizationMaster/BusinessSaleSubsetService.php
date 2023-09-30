<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessSaleSubsetInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\BusinessSaleSubset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessSaleSubsetService
{
    protected $BusinessSaleSubsetInterface;
    public function __construct(BusinessSaleSubsetInterface $BusinessSaleSubsetInterface)
    {
        $this->BusinessSaleSubsetInterface = $BusinessSaleSubsetInterface;
    }

    public function index()
    {
        $models = $this->BusinessSaleSubsetInterface->index();
        $entities = $models->map(function ($model) {
            $businessSaleSubset = $model->business_sale_subset;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['businessSaleSubset' => $businessSaleSubset, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'businessSaleSubset' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertBusinessSaleSubset($datas);
        $storeModel = $this->BusinessSaleSubsetInterface->store($convert);
        Log::info('BusinessSaleSubsetService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getBusinessSaleSubsetById($id)
    {
        $model = $this->BusinessSaleSubsetInterface->getBusinessSaleSubsetById($id);
        $datas = array();
        if ($model) {
            $businessSaleSubset = $model->business_sale_subset;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['businessSaleSubset' => $businessSaleSubset,'description'=>$description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBusinessSaleSubset($datas)
    {
        $model = $this->BusinessSaleSubsetInterface->getBusinessSaleSubsetById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new BusinessSaleSubset();
            $model->created_by=auth()->user()->id;
        }
        $model->business_sale_subset = $datas->businessSaleSubset;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBusinessSaleSubsetById($id)
    {
        $destory = $this->BusinessSaleSubsetInterface->destroyBusinessSaleSubset($id);
        return new SuccessApiResponse($destory, 200);
    }
}
