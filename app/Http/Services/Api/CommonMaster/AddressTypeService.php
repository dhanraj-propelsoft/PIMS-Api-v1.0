<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\AddressTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\AddressType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AddressTypeService
{
    protected $AddressTypeInterface;
    public function __construct(AddressTypeInterface $AddressTypeInterface)
    {
        $this->AddressTypeInterface = $AddressTypeInterface;
    }

    public function index()
    {
        $models = $this->AddressTypeInterface->index();
        $entities = $models->map(function ($model) {
            $addressType = $model->address_of;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $id = $model->id;
            $datas = ['addressType' => $addressType, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'addressType' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertAddressType($datas);
        $storeModel = $this->AddressTypeInterface->store($convert);
        Log::info('AddressTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getAddressTypeById($id )
    {
        $model = $this->AddressTypeInterface->getAddressTypeById($id);
        $datas = array();
        if ($model) {
            $addressType = $model->address_of;
            $status = ($model->pfm_active_status_id== 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $id = $model->id;
            $datas = ['addressType' => $addressType, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertAddressType($datas)
    {
        $model = $this->AddressTypeInterface->getAddressTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new AddressType();
            $model->created_by=auth()->user()->id;
        }
        $model->address_of = $datas->addressType;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :null;
        return $model;
    }

    public function destroyAddressTypeById($id)
    {
        $destory = $this->AddressTypeInterface->destroyAddressType($id);
        return new SuccessApiResponse($destory, 200);
    }
}