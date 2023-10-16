<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\MaritalStatusInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\MaritalStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class MaritalStatusService
{
    protected $MaritalStatusInterface;
    public function __construct(MaritalStatusInterface $MaritalStatusInterface, ActiveStatusInterface $ActiveStatusInterface )
    {
        $this->MaritalStatusInterface = $MaritalStatusInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

    public function index()
    {

        $models = $this->MaritalStatusInterface->index();
        $entities = $models->map(function ($model) {
            $maritalStatus = $model->marital_status;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $maritalStatusId = $model->id;
            $datas = ['maritalStatus' => $maritalStatus, 'status' => $status, 'maritalStatusId' => $maritalStatusId, 'description' => $description];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {

      
        $validation = $this->ValidationForMaritalStatus($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertMaritalStatus($datas);
        $storeModel = $this->MaritalStatusInterface->store($convert);
        Log::info('BloodGroupService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForMaritalStatus($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'maritalStatus') {
                $rules['maritalStatus'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_marital_statues', 'marital_status')->where(function ($query) use ($datas) {
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
    public function convertMaritalStatus($datas)
    {

        if (isset($datas->id)) {
            $model = $this->MaritalStatusInterface->getMaritalStatusById($datas->id);
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
    public function getMaritalStatusById($maritalId)
    {
        $model = $this->MaritalStatusInterface->getMaritalStatusById($maritalId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {

            $maritalStatus = $model->marital_status;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $maritalStatusId = $model->id;
            $datas = ['maritalStatus' => $maritalStatus, 'status' => $status, 'activeStatusId' => $activeStatusId, 'maritalStatusId' => $maritalStatusId, 'description' => $description,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyMaritalStatusById($maritalId)
    {
        $destory = $this->MaritalStatusInterface->destroyMaritalStatus($maritalId);
        return new SuccessApiResponse($destory, 200);
    }
}