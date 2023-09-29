<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BloodGroupInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\BloodGroup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BloodGroupService
{
    protected $BloodGroupInterface;
    public function __construct(BloodGroupInterface $BloodGroupInterface)
    {
        $this->BloodGroupInterface = $BloodGroupInterface;
    }

    public function index()
    {
        $models = $this->BloodGroupInterface->index();
        $entities = $models->map(function ($model) {
            $bloodGroup = $model->blood_group;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['bloodGroup' => $bloodGroup, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);

    }

    public function store($datas)
    {

        $validator = Validator::make($datas, [
            'bloodGroup' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertBloodGroup($datas);
        $storeModel = $this->BloodGroupInterface->store($convert);
        Log::info('BloodGroupService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function convertBloodGroup($datas)
    {
        $model = $this->BloodGroupInterface->getBloodGroupById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new BloodGroup();
            $model->created_by=auth()->user()->id;
        }
        $model->blood_group = $datas->bloodGroup;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }
    public function getBloodGroupById($id)
    {
        $model = $this->BloodGroupInterface->getBloodGroupById($id);
        $datas = array();
        if ($model) {

            $bloodGroup = $model->blood_group;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['bloodGroup' => $bloodGroup, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyBloodGroupById($id)
    {
        $destory = $this->BloodGroupInterface->destroyBloodGroup($id);
        return new SuccessApiResponse($destory, 200);
    }
}
