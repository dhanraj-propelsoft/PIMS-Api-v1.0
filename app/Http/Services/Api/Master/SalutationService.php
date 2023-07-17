<?php

namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\salutationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonSalutation;
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
            $name = $model->salutation;
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
    public function getSalutationById($id = null)
    {
        $model = $this->SalutationInterface->getSalutationById($id);
        $datas = array();
        if ($model) {
            // Modify $item and return the modified value
            $name = $model->salutation;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertSalutation($datas)
    {

        $datasArray = json_decode(json_encode($datas), true);
        $model = $this->SalutationInterface->getSalutationById(isset($datasArray['id']) ? $datasArray['id'] : '');

        if ($model) {
            $model->id = $datasArray['id'];
        } else {
            $model = new PimsPersonSalutation();
        }


        $model->salutation = $datasArray['salutation'];
        $model->active_status = isset($datasArray['active_status']) ? $datasArray['active_status'] : null;
        return $model;
    }
    public function destroySalutationById($id)
    {
        $destory = $this->SalutationInterface->destroySalutation($id);
        return new SuccessApiResponse($destory, 200);
    }
}
