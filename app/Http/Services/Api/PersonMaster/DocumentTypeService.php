<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\DocumentTypeInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DocumentTypeService
{
    protected $DocumentTypeInterface;
    public function __construct(DocumentTypeInterface $DocumentTypeInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->DocumentTypeInterface = $DocumentTypeInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

    public function index()
    {

        $models = $this->DocumentTypeInterface->index();
        $entities = $models->map(function ($model) {
            $docType = $model->person_doc_type;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $mandatoryStatus = $model->mandatory_status;
            $docTypeId = $model->id;
            $datas = ['mandatoryStatus' => $mandatoryStatus, 'description' => $description, 'docType' => $docType, 'status' => $status, 'docTypeId' => $docTypeId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validation = $this->ValidationForDocumentType($datas);
        if ($validation->data['errors'] === false) {      
        $datas = (object) $datas;
        $convert = $this->convertDocumentType($datas);
        $storeModel = $this->DocumentTypeInterface->store($convert);
        Log::info('DocumentTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForDocumentType($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'documentType') {
                $rules['documentType'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_document_types', 'person_doc_type')->where(function ($query) use ($datas) {
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
    public function getDocumentTypeById($docTypeId)
    {
        $model = $this->DocumentTypeInterface->getDocumentTypeById($docTypeId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $docType = $model->person_doc_type;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $mandatoryStatus = $model->mandatory_status;
            $docTypeId = $model->id;
            $datas = ['docType' => $docType, 'status' => $status, 'activeStatusId' => $activeStatusId, 'docTypeId' => $docTypeId,'description'=>$description,'mandatoryStatus'=>$mandatoryStatus,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertDocumentType($datas)
    {

        if (isset($datas->id)) {
            $model = $this->DocumentTypeInterface->getDocumentTypeById($datas->id);
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

    public function destroyDocumentTypeById($docTypeId)
    {
        $destory = $this->DocumentTypeInterface->destroyDocumentType($docTypeId);
        return new SuccessApiResponse($destory, 200);
    }
}
