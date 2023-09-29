<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\ActiveStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ActiveStatusService
{
    protected $ActiveStatusInterface;
    public function __construct(ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->ActiveStatusInterface->index();
        $entities = $models->map(function ($model) {
            $activeType = $model->active_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['activeType' => $activeType, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'activeType' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertActiveStatus($datas);
        $storeModel = $this->ActiveStatusInterface->store($convert);
        Log::info('ActiveStatusService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getActiveStatusById($id )
    {
        $model = $this->ActiveStatusInterface->getActiveStatusById($id);
        $datas = array();
        if ($model) {
            $activeType = $model->active_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['activeType' => $activeType, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertActiveStatus($datas)
    {
        $model = $this->ActiveStatusInterface->getActiveStatusById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new ActiveStatus();
        }
        $model->active_type = $datas->activeType;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->active_status = isset($datas->activeStatus) ? $datas->activeStatus : '0';
        return $model;
    }

    public function destroyActiveStatusById($id)
    {
        $destory = $this->ActiveStatusInterface->destroyActiveStatus($id);
        return new SuccessApiResponse($destory, 200);
    }
}
