<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\DocumentTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\DocumentType;
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
            $docType = $model->person_doc_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $mandatoryStatus = $model->mandatory_status;
            $id = $model->id;
            $datas = ['mandatoryStatus' => $mandatoryStatus, 'description' => $description, 'docType' => $docType, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
            $docType = $model->person_doc_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $mandatoryStatus = $model->mandatory_status;
            $id = $model->id;
            $datas = ['docType' => $docType, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id,'description'=>$description,'mandatoryStatus'=>$mandatoryStatus];
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
        $model->person_doc_type = $datas->documentType;
        $model->mandatory_status = isset($datas->mandatoryStatus) ? $datas->mandatoryStatus :Null;
        $model->description = isset($datas->description) ? $datas->description :Null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :Null;
        return $model;
    }

    public function destroyDocumentTypeById($id)
    {
        $destory = $this->DocumentTypeInterface->destroyDocumentType($id);
        return new SuccessApiResponse($destory, 200);
    }
}
