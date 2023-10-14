<?php

namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\salutationInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Salutation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SalutationService
{
    protected $SalutationInterface;
    public function __construct(salutationInterface $SalutationInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->SalutationInterface = $SalutationInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->SalutationInterface->index();
 
        $entities = $models->map(function ($model) {
            $salutation = $model->salutation;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $salutationId = $model->id;
            $datas = ['salutation' => $salutation, 'status' => $status,  'salutationId' => $salutationId,'description'=> $description ];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {

        $validation = $this->ValidationForSalutation($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertSalutation($datas);
        $storeModel = $this->SalutationInterface->store($convert);
        Log::info('SalutationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForSalutation($datas)
    {
       
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'salutation') {
                $rules['salutation'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_salutations', 'salutation')->where(function ($query) use ($datas) {
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
    public function getSalutationById($salutationId )
    {
        $model = $this->SalutationInterface->getSalutationById($salutationId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $salutation = $model->salutation;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $salutationId = $model->id;
            $datas = ['salutation' => $salutation, 'status' => $status, 'activeStatusId' => $activeStatusId, 'salutationId' => $salutationId, 'description' => $description,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertSalutation($datas)
    {

        if (isset($datas->id)) {
            $model = $this->SalutationInterface->getSalutationById($datas->id);
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Salutation();
            $model->created_by=auth()->user()->id;
        }
        $model->salutation = $datas->salutation;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :null;
        return $model;
    }
    public function destroySalutationById($salutationId)
    {
        $destory = $this->SalutationInterface->destroySalutation($salutationId);
        return new SuccessApiResponse($destory, 200);   
    }
}
