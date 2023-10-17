<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OwnerShipInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\OwnerShip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OwnerShipService
{
    protected $OwnerShipInterface, $ActiveStatusInterface;
    public function __construct(OwnerShipInterface $OwnerShipInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->OwnerShipInterface = $OwnerShipInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->OwnerShipInterface->index();
        $entities = $models->map(function ($model) {
            $ownerShip = $model->org_ownership;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $ownershipId = $model->id;
            $datas = ['ownerShip' => $ownerShip, 'description' => $description, 'status' => $status, 'ownershipId' => $ownershipId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForOwnership($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertOwnerShip($datas);
        $storeModel = $this->OwnerShipInterface->store($convert);
        Log::info('OwnerShipService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }

    public function ValidationForOwnership($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'ownership') {
                $rules['ownership'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_ownerships', 'org_ownership')->where(function ($query) use ($datas) {
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

    public function getOwnerShipById($ownershipId)
    {
        $model = $this->OwnerShipInterface->getOwnerShipById($ownershipId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $ownerShip = $model->org_ownership;
            $status = $model->activeStatus->active_type;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $ownershipId = $model->id;
            $datas = ['ownerShip' => $ownerShip,'description'=>$description ,'status' => $status, 'activeStatus' => $activeStatus, 'ownershipId' => $ownershipId, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOwnerShip($datas)
    {
        if (isset($datas->id)) {
            $model = $this->OwnerShipInterface->getOwnerShipById($datas->id);
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new OwnerShip();
            $model->created_by=auth()->user()->id;

        }
        $model->org_ownership = $datas->ownership;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyOwnerShipById($ownershipId)
    {
        $destroy = $this->OwnerShipInterface->destroyOwnerShip($ownershipId);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
