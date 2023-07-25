<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessSaleSubsetInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgBusinessSaleSubset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgBusinessSaleSubsetService
{
    protected $OrgBusinessSaleSubsetInterface;
    public function __construct(OrgBusinessSaleSubsetInterface $OrgBusinessSaleSubsetInterface)
    {
        $this->OrgBusinessSaleSubsetInterface = $OrgBusinessSaleSubsetInterface;
    }

    public function index()
    {
        $models = $this->OrgBusinessSaleSubsetInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->business_sale_subset;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
        $convert = $this->convertOrgBusinessSaleSubset($datas);
        $storeModel = $this->OrgBusinessSaleSubsetInterface->store($convert);
        Log::info('OrgBusinessSaleSubsetService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgBusinessSaleSubsetById($id = null)
    {
        $model = $this->OrgBusinessSaleSubsetInterface->getOrgBusinessSaleSubsetById($id);
        $datas = array();
        if ($model) {
            $name = $model->business_sale_subset;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgBusinessSaleSubset($datas)
    {
        $model = $this->OrgBusinessSaleSubsetInterface->getOrgBusinessSaleSubsetById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgBusinessSaleSubset();
        }
        $model->business_sale_subset = $datas->businessSaleSubset;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgBusinessSaleSubsetById($id)
    {
        $destory = $this->OrgBusinessSaleSubsetInterface->destroyOrgBusinessSaleSubset($id);
        return new SuccessApiResponse($destory, 200);
    }
}