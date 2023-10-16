<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BloodGroupInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\BloodGroup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BloodGroupService
{
    protected $BloodGroupInterface;
    public function __construct(BloodGroupInterface $BloodGroupInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->BloodGroupInterface = $BloodGroupInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

    public function index()
    {
        $models = $this->BloodGroupInterface->index();
        $entities = $models->map(function ($model) {
            $bloodGroup = $model->blood_group;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $bloodGroupId = $model->id;
            $datas = ['bloodGroup' => $bloodGroup, 'status' => $status,  'bloodGroupId' => $bloodGroupId, 'description' => $description];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);

    }

    public function store($datas)
    {

        $validation = $this->ValidationForBloodGroup($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertBloodGroup($datas);
        $storeModel = $this->BloodGroupInterface->store($convert);
        Log::info('BloodGroupService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForBloodGroup($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'bloodGroup') {
                $rules['bloodGroup'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_blood_groups', 'blood_group')->where(function ($query) use ($datas) {
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
    public function convertBloodGroup($datas)
    {

        if (isset($datas->id)) {
            $model = $this->BloodGroupInterface->getBloodGroupById($datas->id);
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
    public function getBloodGroupById($bloodGroupId)
    {
        $model = $this->BloodGroupInterface->getBloodGroupById($bloodGroupId);
        $activeStatus =$this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {

            $bloodGroup = $model->blood_group;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $bloodGroupId = $model->id;
            $datas = ['bloodGroup' => $bloodGroup, 'status' => $status, 'activeStatusId' => $activeStatusId, 'bloodGroupId' => $bloodGroupId, 'description' => $description,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyBloodGroupById($bloodGroupId)
    {
        $destory = $this->BloodGroupInterface->destroyBloodGroup($bloodGroupId);
        return new SuccessApiResponse($destory, 200);
    }
}
