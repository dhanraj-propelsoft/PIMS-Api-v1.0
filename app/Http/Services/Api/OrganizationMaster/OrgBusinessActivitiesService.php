<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgBusinessActivitiesInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgBusinessActivities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgBusinessActivitiesService
{
    protected $OrgBusinessActivitiesInterface;
    public function __construct(OrgBusinessActivitiesInterface $OrgBusinessActivitiesInterface)
    {
        $this->OrgBusinessActivitiesInterface = $OrgBusinessActivitiesInterface;
    }

    public function index()
    {
        $models = $this->OrgBusinessActivitiesInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->business_activity;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
        $convert = $this->convertOrgBusinessActivities($datas);
        $storeModel = $this->OrgBusinessActivitiesInterface->store($convert);
        Log::info('OrgBusinessActivitiesService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgBusinessActivitiesById($id )
    {
        $model = $this->OrgBusinessActivitiesInterface->getOrgBusinessActivitiesById($id);
        $datas = array();
        if ($model) {
            $name = $model->business_activity;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgBusinessActivities($datas)
    {
        $model = $this->OrgBusinessActivitiesInterface->getOrgBusinessActivitiesById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgBusinessActivities();
        }
        $model->business_activity = $datas->businessActivity;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgBusinessActivitiesById($id)
    {
        $destory = $this->OrgBusinessActivitiesInterface->destroyOrgBusinessActivities($id);
        return new SuccessApiResponse($destory, 200);
    }
}