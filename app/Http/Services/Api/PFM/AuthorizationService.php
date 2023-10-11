<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\AuthorizationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Authorization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthorizationService
{
    protected $AuthorizationInterface;
    public function __construct(AuthorizationInterface $AuthorizationInterface)
    {
        $this->AuthorizationInterface = $AuthorizationInterface;
    }

    public function index()
    {
        $models = $this->AuthorizationInterface->index();
        $entities = $models->map(function ($model) {
            $authorization = $model->authorization;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['authorization' => $authorization, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'authorization' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertAuthorization($datas);
        $storeModel = $this->AuthorizationInterface->store($convert);
        Log::info('AuthorizationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getAuthorizationById($id )
    {
        $model = $this->AuthorizationInterface->getAuthorizationById($id);
        $datas = array();
        if ($model) {
            $authorization = $model->authorization;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['authorization' => $authorization, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertAuthorization($datas)
    {
        $model = $this->AuthorizationInterface->getAuthorizationById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Authorization();
            $model->created_by=auth()->user()->id;
        }
        $model->authorization = $datas->authorization;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :null;
        return $model;
    }

    public function destroyAuthorizationById($id)
    {
        $destory = $this->AuthorizationInterface->destroyAuthorization($id);
        return new SuccessApiResponse($destory, 200);
    }
}