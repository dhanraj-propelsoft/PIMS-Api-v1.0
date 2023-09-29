<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\AreaInterface;
use App\Http\Interfaces\Api\CommonMaster\DistrictInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Area;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AreaService
{
    protected $AreaInterface;
    public function __construct(AreaInterface $AreaInterface, DistrictInterface $DistrictInterface)
    {
        $this->AreaInterface = $AreaInterface;
        $this->DistrictInterface = $DistrictInterface;
    }

    public function index()
    {

        $models = $this->AreaInterface->index();
        $district = $this->DistrictInterface->index();
        $entities = $models->map(function ($model) use ($district) {
            $area = $model->area;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $districtData = $district->firstWhere('id', $model->district_id);
            $districtName = ($districtData) ? $districtData->district : null;
            $datas = ['districtName' => $districtName, 'description'=>$description,'area' => $area, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {

        $validator = Validator::make($datas, [
            'area' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertArea($datas);
        $storeModel = $this->AreaInterface->store($convert);
        Log::info('AreaService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getAreaById($id)
    {
        $model = $this->AreaInterface->getAreaById($id);
        $district = $this->DistrictInterface->index();
        $datas = array();
        if ($model) {
            $area = $model->area;
            $districtId = $model->district_id;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $districtData = $district->firstWhere('id', $districtId);
            $districtName = ($districtData) ? $districtData->district : null;
            $datas = ['districtId' => $districtId, 'districtName' => $districtName,'description'=>$description, 'area' => $area, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertArea($datas)
    {
        $model = $this->AreaInterface->getAreaById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Area();
            $model->created_by = auth()->user()->id;
        }
        $model->area = $datas->area;
        $model->district_id = isset($datas->districtId) ? $datas->districtId : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        $model->pin_code = isset($datas->pinCode) ? $datas->pinCode : null;

        return $model;
    }

    public function destroyAreaById($id)
    {
        $destory = $this->AreaInterface->destroyArea($id);
        return new SuccessApiResponse($destory, 200);
    }
}
