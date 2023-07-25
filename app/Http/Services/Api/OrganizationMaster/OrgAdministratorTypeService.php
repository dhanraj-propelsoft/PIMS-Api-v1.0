<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgAdministratorTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgAdministratorType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgAdministratorTypeService
{
    protected $OrgAdministratorTypeInterface;
    public function __construct(OrgAdministratorTypeInterface $OrgAdministratorTypeInterface)
    {
        $this->OrgAdministratorTypeInterface = $OrgAdministratorTypeInterface;
    }

    public function index()
    {
        $models = $this->OrgAdministratorTypeInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->org_administrator_type;
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
            'administratorType' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrgAdministratorType($datas);
        $storeModel = $this->OrgAdministratorTypeInterface->store($convert);
        Log::info('OrgAdministratorTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgAdministratorTypeById($id = null)
    {
        $model = $this->OrgAdministratorTypeInterface->getOrgAdministratorTypeById($id);
        $datas = array();
        if ($model) {
            $name = $model->org_administrator_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgAdministratorType($datas)
    {
        $model = $this->OrgAdministratorTypeInterface->getOrgAdministratorTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgAdministratorType();
        }
        $model->org_administrator_type = $datas->administratorType;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgAdministratorTypeById($id)
    {
        $destory = $this->OrgAdministratorTypeInterface->destroyOrgAdministratorType($id);
        return new SuccessApiResponse($destory, 200);
    }
}
