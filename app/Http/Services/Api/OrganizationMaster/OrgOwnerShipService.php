<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgOwnerShipInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgOwnerShip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgOwnerShipService
{
    protected $OrgOwnerShipInterface;
    public function __construct(OrgOwnerShipInterface $OrgOwnerShipInterface)
    {
        $this->OrgOwnerShipInterface = $OrgOwnerShipInterface;
    }

    public function index()
    {
        $models = $this->OrgOwnerShipInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->org_ownership;
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
            'orgOwnerShip' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrgOwnerShip($datas);
        $storeModel = $this->OrgOwnerShipInterface->store($convert);
        Log::info('OrgOwnerShipService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgOwnerShipById($id )
    {
        $model = $this->OrgOwnerShipInterface->getOrgOwnerShipById($id);
        $datas = array();
        if ($model) {
            $name = $model->org_ownership;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgOwnerShip($datas)
    {
        $model = $this->OrgOwnerShipInterface->getOrgOwnerShipById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgOwnerShip();
        }
        $model->org_ownership = $datas->orgOwnerShip;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgOwnerShipById($id)
    {
        $destory = $this->OrgOwnerShipInterface->destroyOrgOwnerShip($id);
        return new SuccessApiResponse($destory, 200);
    }
}