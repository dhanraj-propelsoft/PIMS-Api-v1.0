<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\ExistenceInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Existence;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExistenceService
{
    protected $ExistenceInterface;
    public function __construct(ExistenceInterface $ExistenceInterface)
    {
        $this->ExistenceInterface = $ExistenceInterface;
    }

    public function index()
    {
        $models = $this->ExistenceInterface->index();
        $entities = $models->map(function ($model) {
            $existence = $model->existence;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;

            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;

            $datas = ['existence' => $existence, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'existence' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertExistence($datas);
        $storeModel = $this->ExistenceInterface->store($convert);
        Log::info('ExistenceService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getExistenceById($id )
    {
        $model = $this->ExistenceInterface->getExistenceById($id);
        $datas = array();
        if ($model) {
            $existence = $model->existence;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['existence' => $existence, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertExistence($datas)
    {
        $model = $this->ExistenceInterface->getExistenceById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new Existence();
            $model->created_by=auth()->user()->id;

        }
        $model->existence = $datas->existence;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyExistenceById($id)
    {
        $destory = $this->ExistenceInterface->destroyExistence($id);
        return new SuccessApiResponse($destory, 200);
    }
}
