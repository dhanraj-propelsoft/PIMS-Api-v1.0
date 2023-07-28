<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\CommonAddressTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsCommonAddressType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommonAddressTypeService
{
    protected $CommonAddressTypeInterface;
    public function __construct(CommonAddressTypeInterface $CommonAddressTypeInterface)
    {
        $this->CommonAddressTypeInterface = $CommonAddressTypeInterface;
    }

    public function index()
    {
        $models = $this->CommonAddressTypeInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->address_of;
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
            'addressOf' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertCommonAddressType($datas);
        $storeModel = $this->CommonAddressTypeInterface->store($convert);
        Log::info('CommonAddressTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCommonAddressTypeById($id )
    {
        $model = $this->CommonAddressTypeInterface->getCommonAddressTypeById($id);
        $datas = array();
        if ($model) {
            $name = $model->address_of;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCommonAddressType($datas)
    {
        $model = $this->CommonAddressTypeInterface->getCommonAddressTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsCommonAddressType();
        }
        $model->address_of = $datas->addressOf;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyCommonAddressTypeById($id)
    {
        $destory = $this->CommonAddressTypeInterface->destroyCommonAddressType($id);
        return new SuccessApiResponse($destory, 200);
    }
}