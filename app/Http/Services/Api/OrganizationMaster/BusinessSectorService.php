<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessSectorInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\BusinessSector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessSectorService
{
    protected $BusinessSectorInterface;
    public function __construct(BusinessSectorInterface $BusinessSectorInterface)
    {
        $this->BusinessSectorInterface = $BusinessSectorInterface;
    }

    public function index()
    {
        $models = $this->BusinessSectorInterface->index();
        $entities = $models->map(function ($model) {
            $businessSector = $model->business_sector;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['businessSector' => $businessSector, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'businessSector' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertBusinessSector($datas);
        $storeModel = $this->BusinessSectorInterface->store($convert);
        Log::info('BusinessSectorService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getBusinessSectorById($id)
    {
        $model = $this->BusinessSectorInterface->getBusinessSectorById($id);
        $datas = array();
        if ($model) {
            $businessSector = $model->business_sector;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['businessSector' => $businessSector, 'description'=>$description,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBusinessSector($datas)
    {
        $model = $this->BusinessSectorInterface->getBusinessSectorById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new BusinessSector();
            $model->created_by=auth()->user()->id;
        }
        $model->business_sector = $datas->businessSector;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBusinessSectorById($id)
    {
        $destory = $this->BusinessSectorInterface->destroyBusinessSector($id);
        return new SuccessApiResponse($destory, 200);
    }
}
