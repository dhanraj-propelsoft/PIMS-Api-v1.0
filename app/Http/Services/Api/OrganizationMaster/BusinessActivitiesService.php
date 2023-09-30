<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessActivitiesInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\BusinessActivities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessActivitiesService
{
    protected $BusinessActivitiesInterface;
    public function __construct(BusinessActivitiesInterface $BusinessActivitiesInterface)
    {
        $this->BusinessActivitiesInterface = $BusinessActivitiesInterface;
    }

    public function index()
    {
        $models = $this->BusinessActivitiesInterface->index();
        $entities = $models->map(function ($model) {
            $businessActivity = $model->business_activity;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $datas = ['businessActivity' => $businessActivity,'description'=>$description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'businessActivity' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertBusinessActivities($datas);
        $storeModel = $this->BusinessActivitiesInterface->store($convert);
        Log::info('BusinessActivitiesService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getBusinessActivitiesById($id)
    {
        $model = $this->BusinessActivitiesInterface->getBusinessActivitiesById($id);
        $datas = array();
        if ($model) {
            $businessActivity = $model->business_activity;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $datas = ['businessActivity' => $businessActivity,'description'=>$description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBusinessActivities($datas)
    {
        $model = $this->BusinessActivitiesInterface->getBusinessActivitiesById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new BusinessActivities();
            $model->created_by=auth()->user()->id;
        }
        $model->business_activity = $datas->businessActivity;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBusinessActivitiesById($id)
    {
        $destory = $this->BusinessActivitiesInterface->destroyBusinessActivities($id);
        return new SuccessApiResponse($destory, 200);
    }
}