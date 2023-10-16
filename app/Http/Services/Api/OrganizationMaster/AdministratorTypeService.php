<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\AdministratorTypeInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\AdministratorType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdministratorTypeService
{
    protected $AdministratorTypeInterface;
    public function __construct(AdministratorTypeInterface $AdministratorTypeInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->AdministratorTypeInterface = $AdministratorTypeInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

    public function index()
    {
        $models = $this->AdministratorTypeInterface->index();
        $entities = $models->map(function ($model) {
            $administratorType = $model->org_administrator_type;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $administratorTypeId = $model->id;
            $datas = ['administratorType' => $administratorType, 'description'=>$description,'status' => $status,  'administratorTypeId' => $administratorTypeId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }

    public function store($datas)
    {
        $validation = $this->ValidationForAdministratorType($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertAdministratorType($datas);
        $storeModel = $this->AdministratorTypeInterface->store($convert);
        Log::info('AdministratorTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForAdministratorType($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'administratorType') {
                $rules['administratorType'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_administrator_types', 'org_administrator_type')->where(function ($query) use ($datas) {
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
    public function getAdministratorTypeById($adminTypeId)
    {
        $model = $this->AdministratorTypeInterface->getAdministratorTypeById($adminTypeId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $administratorType = $model->org_administrator_type;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $administratorTypeId = $model->id;
            $datas = ['administratorType' => $administratorType,'description'=>$description ,'status' => $status, 'activeStatusId' => $activeStatusId, 'administratorTypeId' => $administratorTypeId,'activeStatus'=>$activeStatus];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertAdministratorType($datas)
    {

        if (isset($datas->id)) {
            $model = $this->AdministratorTypeInterface->getAdministratorTypeById($datas->id );
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

    public function destroyAdministratorTypeById($adminTypeId)
    {
        $destory = $this->AdministratorTypeInterface->destroyAdministratorType($adminTypeId);
        return new SuccessApiResponse($destory, 200);
    }
}
