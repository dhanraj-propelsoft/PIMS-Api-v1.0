<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\AddressTypeInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\AddressType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddressTypeService
{
    protected $AddressTypeInterface;
    public function __construct(AddressTypeInterface $AddressTypeInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->AddressTypeInterface = $AddressTypeInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->AddressTypeInterface->index();
        $entities = $models->map(function ($model) {
            $addressType = $model->address_of;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $addressId = $model->id;
            $datas = ['addressType' => $addressType, 'description' => $description, 'status' => $status, 'addressId' => $addressId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForAddressType($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertAddressType($datas);
            $storeModel = $this->AddressTypeInterface->store($convert);
            Log::info('AddressTypeService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation->data['errors'];
        }
    }
    public function ValidationForAddressType($datas)
    {
       
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'addressType') {
                $rules['addressType'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_address_types', 'address_of')->where(function ($query) use ($datas) {
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
    public function getAddressTypeById($addressId)
    {
        $model = $this->AddressTypeInterface->getAddressTypeById($addressId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $addressType = $model->address_of;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $addressId = $model->id;
            $datas = ['addressType' => $addressType, 'description' => $description, 'status' => $status, 'addressId' => $addressId, 'activeStatusId' => $activeStatusId,'activeStatus' => $activeStatus];
            return $datas;
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertAddressType($datas)
    {

        if (isset($datas->id)) {
            $model = $this->AddressTypeInterface->getAddressTypeById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new AddressType();
            $model->created_by = auth()->user()->id;
        }
        $model->address_of = $datas->addressType;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyAddressTypeById($addressId)
    {
        $destory = $this->AddressTypeInterface->destroyAddressType($addressId);
        return new SuccessApiResponse($destory, 200);
    }
}
