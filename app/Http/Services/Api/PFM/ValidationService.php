<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\ValidationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Validation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ValidationService
{
    protected $ValidationInterface;
    public function __construct(ValidationInterface $ValidationInterface)
    {
        $this->ValidationInterface = $ValidationInterface;
    }

    public function index()
    {
        $models = $this->ValidationInterface->index();
        $entities = $models->map(function ($model) {
            $validation = $model->validation;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['validation' => $validation, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'validation' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertValidation($datas);
        $storeModel = $this->ValidationInterface->store($convert);
        Log::info('ValidationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getValidationById($id )
    {
        $model = $this->ValidationInterface->getValidationById($id);
        $datas = array();
        if ($model) {
            $validation = $model->validation;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['validation' => $validation, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertValidation($datas)
    {
        $model = $this->ValidationInterface->getValidationById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new Validation();
        }
        $model->validation = $datas->validation;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : '0';
        return $model;
    }

    public function destroyValidationById($id)
    {
        $destory = $this->ValidationInterface->destroyValidation($id);
        return new SuccessApiResponse($destory, 200);
    }
}
