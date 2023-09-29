<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\MaritalStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\MaritalStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class MaritalStatusService
{
    protected $MaritalStatusInterface;
    public function __construct(MaritalStatusInterface $MaritalStatusInterface)
    {
        $this->MaritalStatusInterface = $MaritalStatusInterface;
    }

    public function index()
    {

        $models = $this->MaritalStatusInterface->index();
        $entities = $models->map(function ($model) {
            $maritalStatus = $model->marital_status;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['maritalStatus' => $maritalStatus, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {

        $validator = Validator::make($datas, [
            'maritalStatus' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            //dd($error);
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertMaritalStatus($datas);
        $storeModel = $this->MaritalStatusInterface->store($convert);
        Log::info('BloodGroupService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function convertMaritalStatus($datas)
    {
        $model = $this->MaritalStatusInterface->getMaritalStatusById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new MaritalStatus();
            $model->created_by=auth()->user()->id;
        }
        $model->marital_status = $datas->maritalStatus;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }
    public function getMaritalStatusById($id)
    {
        $model = $this->MaritalStatusInterface->getMaritalStatusById($id);
        $datas = array();
        if ($model) {

            $maritalStatus = $model->marital_status;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['maritalStatus' => $maritalStatus, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyMaritalStatusById($id)
    {
        $destory = $this->MaritalStatusInterface->destroyMaritalStatus($id);
        return new SuccessApiResponse($destory, 200);
    }
}