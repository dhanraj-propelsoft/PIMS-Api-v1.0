<?php

namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\BusinessSectorInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\BusinessSector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessSectorService
{
    protected $BusinessSectorInterface, $ActiveStatusInterface;
    public function __construct(BusinessSectorInterface $BusinessSectorInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->BusinessSectorInterface = $BusinessSectorInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->BusinessSectorInterface->index();
        $entities = $models->map(function ($model) {
            $businessSector = $model->business_sector;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $businessSectorId = $model->id;
            $datas = ['businessSector' => $businessSector, 'description' => $description, 'status' => $status, 'businessSectorId' => $businessSectorId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForBusinessSector($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertBusinessSector($datas);
            $storeModel = $this->BusinessSectorInterface->store($convert);
            Log::info('BusinessSectorService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation->data['errors'];
        }
    }
    public function ValidationForBusinessSector($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'businessSector') {
                $rules['businessSector'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_business_sectors', 'business_sector')->where(function ($query) use ($datas) {
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
    public function getBusinessSectorById($businessSectorId)
    {
        $model = $this->BusinessSectorInterface->getBusinessSectorById($businessSectorId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $businessSector = $model->business_sector;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $businessSectorId = $model->id;
            $datas = ['businessSector' => $businessSector, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'businessSectorId' => $businessSectorId, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);
    }
    public function convertBusinessSector($datas)
    {

        if (isset($datas->id)) {
            $model = $this->BusinessSectorInterface->getBusinessSectorById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new BusinessSector();
            $model->created_by = auth()->user()->id;
        }
        $model->business_sector = $datas->businessSector;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBusinessSectorById($businessSectorId)
    {
        $destroy = $this->BusinessSectorInterface->destroyBusinessSector($businessSectorId);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
