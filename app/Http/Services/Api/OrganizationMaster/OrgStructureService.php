<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgStructureInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgStructure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgStructureService
{
    protected $OrgStructureInterface;
    public function __construct(OrgStructureInterface $OrgStructureInterface)
    {
        $this->OrgStructureInterface = $OrgStructureInterface;
    }

    public function index()
    {
        $models = $this->OrgStructureInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->org_structure;
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
            'orgStructure' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrgStructure($datas);
        $storeModel = $this->OrgStructureInterface->store($convert);
        Log::info('OrgStructureService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgStructureById($id )
    {
        $model = $this->OrgStructureInterface->getOrgStructureById($id);
        $datas = array();
        if ($model) {
            $name = $model->org_structure;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgStructure($datas)
    {
        $model = $this->OrgStructureInterface->getOrgStructureById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgStructure();
        }
        $model->org_structure = $datas->orgStructure;
        $model->pfm_active_status_id = isset($datas->active_status) ? $datas->active_status : '0';
        $model->description = isset($datas->description) ? $datas->description : null;
        return $model;
    }

    public function destroyOrgStructureById($id)
    {
        $destory = $this->OrgStructureInterface->destroyOrgStructure($id);
        return new SuccessApiResponse($destory, 200);
    }
}
