<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessActivitiesInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\BusinessActivities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessActivitiesService
{
    protected $BusinessActivitiesInterface;
    public function __construct(BusinessActivitiesInterface $BusinessActivitiesInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->BusinessActivitiesInterface = $BusinessActivitiesInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

    public function index()
    {
        $models = $this->BusinessActivitiesInterface->index();
        $entities = $models->map(function ($model) {
            $businessActivity = $model->business_activity;
            $status = $model->activeStatus->active_type;
            $description=$model->description;
            $businessActivityId = $model->id;
            $datas = ['businessActivity' => $businessActivity,'description'=>$description, 'status' => $status,  'businessActivityId' => $businessActivityId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForBusinessActivity($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertBusinessActivities($datas);
        $storeModel = $this->BusinessActivitiesInterface->store($convert);
        Log::info('BusinessActivitiesService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForBusinessActivity($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'businessActivity') {
                $rules['businessActivity'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_business_activities', 'business_activity')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),

                ];
            }
        }
        $validator = Validator::make($datas, $rules);
        if ($validator->fails()) {

            $resStatus = ['errors' => $validator->errors()];
            $resCode = 400;

        } else {

            $resStatus = ['errors' => false];
            $resCode = 200;

        }
        return new SuccessApiResponse($resStatus, $resCode);
    }
    public function getBusinessActivitiesById($businessActivityId)
    {
        $model = $this->BusinessActivitiesInterface->getBusinessActivitiesById($businessActivityId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $businessActivity = $model->business_activity;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description=$model->description;
            $businessActivityId = $model->id;
            $datas = ['businessActivity' => $businessActivity,'description'=>$description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'businessActivityId' => $businessActivityId,'activeStatus'=>$activeStatus];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBusinessActivities($datas)
    {

        if (isset($datas->id)) {
            $model = $this->BusinessActivitiesInterface->getBusinessActivitiesById($datas->id);
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

    public function destroyBusinessActivitiesById($businessActivityId)
    {
        $destory = $this->BusinessActivitiesInterface->destroyBusinessActivities($businessActivityId);
        return new SuccessApiResponse($destory, 200);
    }
}