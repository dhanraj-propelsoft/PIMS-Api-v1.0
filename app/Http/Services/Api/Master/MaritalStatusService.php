<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\MaritalStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonMaritalStatus;
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
            $name = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
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
        } else {
            $model = new PimsPersonMaritalStatus();
        }
        $model->name = $datas->maritalStatus;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }
    public function getMaritalStatusById($id = null)
    {
        $model = $this->MaritalStatusInterface->getMaritalStatusById($id);
        $datas = array();
        if ($model) {

            $name = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyMaritalStatusById($id)
    {
        $destory = $this->MaritalStatusInterface->destroyMaritalStatus($id);
        return new SuccessApiResponse($destory, 200);
    }
}