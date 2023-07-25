<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\DocumentTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonDocumentType;
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
            $name = $model->person_doc_type;
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
    public function getDocumentTypeById($id = null)
    {
        $model = $this->DocumentTypeInterface->getDocumentTypeById($id);
        $datas = array();
        if ($model) {
            $name = $model->person_doc_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertDocumentType($datas)
    {
        $model = $this->DocumentTypeInterface->getDocumentTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsPersonDocumentType();
        }
        $model->person_doc_type = $datas->documentType;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyDocumentTypeById($id)
    {
        $destory = $this->DocumentTypeInterface->destroyDocumentType($id);
        return new SuccessApiResponse($destory, 200);
    }
}