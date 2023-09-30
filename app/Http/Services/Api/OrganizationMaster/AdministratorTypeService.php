<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\AdministratorTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\AdministratorType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdministratorTypeService
{
    protected $AdministratorTypeInterface;
    public function __construct(AdministratorTypeInterface $AdministratorTypeInterface)
    {
        $this->AdministratorTypeInterface = $AdministratorTypeInterface;
    }

    public function index()
    {
        $models = $this->AdministratorTypeInterface->index();
        $entities = $models->map(function ($model) {
            $administratorType = $model->org_administrator_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['administratorType' => $administratorType, 'description'=>$description,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
        $convert = $this->convertAdministratorType($datas);
        $storeModel = $this->AdministratorTypeInterface->store($convert);
        Log::info('AdministratorTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getAdministratorTypeById($id )
    {
        $model = $this->AdministratorTypeInterface->getAdministratorTypeById($id);
        $datas = array();
        if ($model) {
            $administratorType = $model->org_administrator_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['administratorType' => $administratorType,'description'=>$description ,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertAdministratorType($datas)
    {
        $model = $this->AdministratorTypeInterface->getAdministratorTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new AdministratorType();
            $model->created_by=auth()->user()->id;
        }
        $model->org_administrator_type = $datas->administratorType;
        $model->description = isset($datas->description) ? $datas->description :null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :null;
        return $model;
    }

    public function destroyAdministratorTypeById($id)
    {
        $destory = $this->AdministratorTypeInterface->destroyAdministratorType($id);
        return new SuccessApiResponse($destory, 200);
    }
}
