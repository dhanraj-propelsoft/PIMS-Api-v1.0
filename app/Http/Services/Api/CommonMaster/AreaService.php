<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\AreaInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Area;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AreaService
{
    protected $AreaInterface;
    public function __construct(AreaInterface $AreaInterface)
    {
        $this->AreaInterface = $AreaInterface;
    }

    public function index()
    {

        $models = $this->AreaInterface->index();
        $entities = $models->map(function ($model) {
            $area = $model->area;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $id = $model->id;
            $datas = ['area' => $area, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
    public function getAreaById($id )
    {
        $model = $this->AreaInterface->getAreaById($id);
        $datas = array();
        if ($model) {
            $area = $model->area;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $id = $model->id;
            $datas = ['area' => $area, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertArea($datas)
    {
        $model = $this->AreaInterface->getAreaById(isset($datas->id) ? $datas->id : '');

        if ($model){
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Area();
            $model->created_by=auth()->user()->id;
        }
        $model->area = $datas->area;
        $model->state_id = isset($datas->stateId) ? $datas->stateId :null;
        $model->description = isset($datas->description) ? $datas->description :null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :null;
        $model->pin_code = isset($datas->pin_code) ? $datas->pin_code :null;

        return $model;
    }

    public function destroyAreaById($id)
    {
        $destory = $this->AreaInterface->destroyArea($id);
        return new SuccessApiResponse($destory, 200);
    }
}
