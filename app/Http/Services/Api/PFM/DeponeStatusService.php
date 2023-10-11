<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\DeponeStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\DeponeStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeponeStatusService
{
    protected $DeponeStatusInterface;
    public function __construct(DeponeStatusInterface $DeponeStatusInterface)
    {
        $this->DeponeStatusInterface = $DeponeStatusInterface;
    }

    public function index()
    {
        $models = $this->DeponeStatusInterface->index();
        $entities = $models->map(function ($model) {
            $deponeStatus = $model->depone_status;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['deponeStatus' => $deponeStatus, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'deponeStatus' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertDeponeStatus($datas);
        $storeModel = $this->DeponeStatusInterface->store($convert);
        Log::info('DeponeStatusService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getDeponeStatusById($id )
    {
        $model = $this->DeponeStatusInterface->getDeponeStatusById($id);
        $datas = array();
        if ($model) {
            $deponeStatus = $model->depone_status;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['deponeStatus' => $deponeStatus, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertDeponeStatus($datas)
    {
        $model = $this->DeponeStatusInterface->getDeponeStatusById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new DeponeStatus();
            $model->created_by=auth()->user()->id;

        }
        $model->depone_status = $datas->deponeStatus;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyDeponeStatusById($id)
    {
        $destory = $this->DeponeStatusInterface->destroyDeponeStatus($id);
        return new SuccessApiResponse($destory, 200);
    }
}