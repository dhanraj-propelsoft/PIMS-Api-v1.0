<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\DocumentTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\DocumentType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DocumentTypeService
{
    protected $DocumentTypeInterface;
    public function __construct(DocumentTypeInterface $DocumentTypeInterface)
    {
        $this->DocumentTypeInterface = $DocumentTypeInterface;
    }

    public function index()
    {
        $models = $this->DocumentTypeInterface->index();
        $entities = $models->map(function ($model) {
            $documentType = $model->org_doc_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['documentType' => $documentType,'description'=>$description ,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'documentType' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertDocumentType($datas);
        $storeModel = $this->DocumentTypeInterface->store($convert);
        Log::info('DocumentTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getDocumentTypeById($id)
    {
        $model = $this->DocumentTypeInterface->getDocumentTypeById($id);
        $datas = array();
        if ($model) {
            $documentType = $model->org_doc_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['documentType' => $documentType, 'description'=>$description ,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertDocumentType($datas)
    {
        $model = $this->DocumentTypeInterface->getDocumentTypeById(isset($datas->id) ? $datas->id : '');
        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new DocumentType();
            $model->created_by=auth()->user()->id;
        }
        $model->org_doc_type = $datas->documentType;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;    
            return $model;
    } 
    public function destroyDocumentTypeById($id)
    {
        $destory = $this->DocumentTypeInterface->destroyDocumentType($id);
        return new SuccessApiResponse($destory, 200);
    }
}