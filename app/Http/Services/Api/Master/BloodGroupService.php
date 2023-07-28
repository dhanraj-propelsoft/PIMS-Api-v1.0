<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\BloodGroupInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonBloodGroup;
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
            $name = $model->blood_group;
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
        } else {
            $model = new PimsPersonBloodGroup();
        }
        $model->blood_group = $datas->bloodGroup;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }
    public function getBloodGroupById($id = null)
    {
        $model = $this->BloodGroupInterface->getBloodGroupById($id);
        $datas = array();
        if ($model) {

            $name = $model->blood_group;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyBloodGroupById($id)
    {
        $destory = $this->BloodGroupInterface->destroyBloodGroup($id);
        return new SuccessApiResponse($destory, 200);
    }
}
