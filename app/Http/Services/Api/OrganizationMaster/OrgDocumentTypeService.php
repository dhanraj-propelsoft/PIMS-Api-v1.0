<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\OrgDocumentTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsOrgDocumentType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrgDocumentTypeService
{
    protected $OrgDocumentTypeInterface;
    public function __construct(OrgDocumentTypeInterface $OrgDocumentTypeInterface)
    {
        $this->OrgDocumentTypeInterface = $OrgDocumentTypeInterface;
    }

    public function index()
    {
        $models = $this->OrgDocumentTypeInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->org_doc_type;
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
            'orgDocumentType' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrgDocumentType($datas);
        $storeModel = $this->OrgDocumentTypeInterface->store($convert);
        Log::info('OrgDocumentTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOrgDocumentTypeById($id = null)
    {
        $model = $this->OrgDocumentTypeInterface->getOrgDocumentTypeById($id);
        $datas = array();
        if ($model) {
            $name = $model->org_doc_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrgDocumentType($datas)
    {
        $model = $this->OrgDocumentTypeInterface->getOrgDocumentTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsOrgDocumentType();
        }
        $model->org_doc_type = $datas->orgDocumentType;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyOrgDocumentTypeById($id)
    {
        $destory = $this->OrgDocumentTypeInterface->destroyOrgDocumentType($id);
        return new SuccessApiResponse($destory, 200);
    }
}