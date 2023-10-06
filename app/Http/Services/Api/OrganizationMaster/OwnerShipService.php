<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OwnerShipInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\OwnerShip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OwnerShipService
{
    protected $OwnerShipInterface;
    public function __construct(OwnerShipInterface $OwnerShipInterface)
    {
        $this->OwnerShipInterface = $OwnerShipInterface;
    }

    public function index()
    {
        $models = $this->OwnerShipInterface->index();
        $entities = $models->map(function ($model) {
            $ownerShip = $model->org_ownership;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['ownerShip' => $ownerShip, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'ownerShip' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOwnerShip($datas);
        $storeModel = $this->OwnerShipInterface->store($convert);
        Log::info('OwnerShipService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOwnerShipById($id)
    {
        $model = $this->OwnerShipInterface->getOwnerShipById($id);
        $datas = array();
        if ($model) {
            $ownerShip = $model->org_ownership;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;

            $id = $model->id;
            $datas = ['ownerShip' => $ownerShip,'description'=>$description ,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOwnerShip($datas)
    {
        $model = $this->OwnerShipInterface->getOwnerShipById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new OwnerShip();
            $model->created_by=auth()->user()->id;

        }
        $model->org_ownership = $datas->ownerShip;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyOwnerShipById($id)
    {
        $destory = $this->OwnerShipInterface->destroyOwnerShip($id);
        return new SuccessApiResponse($destory, 200);
    }
}
