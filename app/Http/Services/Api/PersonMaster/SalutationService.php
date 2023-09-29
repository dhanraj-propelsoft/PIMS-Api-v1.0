<?php

namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\salutationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Salutation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class SalutationService
{
    protected $SalutationInterface;
    public function __construct(salutationInterface $SalutationInterface)
    {
        $this->SalutationInterface = $SalutationInterface;
    }

    public function index()
    {
        $models = $this->SalutationInterface->index();
        $entities = $models->map(function ($model) {
            // Modify $item and return the modified value
            $salutation = $model->salutation;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['salutation' => $salutation, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id,'description'=> $description ];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {

        $validator = Validator::make($datas, [
            'salutation' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            //dd($error);
            return new ErrorApiResponse($error, 300);
        }

        $datas = (object) $datas;

        $convert = $this->convertSalutation($datas);
        $storeModel = $this->SalutationInterface->store($convert);
        Log::info('SalutationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getSalutationById($id )
    {
        $model = $this->SalutationInterface->getSalutationById($id);
        $datas = array();
        if ($model) {
            $salutation = $model->salutation;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['salutation' => $salutation, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertSalutation($datas)
    {
        $model = $this->SalutationInterface->getSalutationById(isset($datas->id) ?$datas->id: '');

        if ($model) {
            $model->id = $datas->id;
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
    public function destroySalutationById($id)
    {
        $destory = $this->SalutationInterface->destroySalutation($id);
        return new SuccessApiResponse($destory, 200);   
    }
}
