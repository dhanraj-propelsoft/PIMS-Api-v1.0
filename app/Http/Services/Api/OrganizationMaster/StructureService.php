<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\StructureInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\Structure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StructureService
{
    protected $StructureInterface;
    public function __construct(StructureInterface $StructureInterface)
    {
        $this->StructureInterface = $StructureInterface;
    }

    public function index()
    {
        $models = $this->StructureInterface->index();
        $entities = $models->map(function ($model) {
            $structure = $model->org_structure;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['structure' => $structure,'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'structure' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertStructure($datas);
        $storeModel = $this->StructureInterface->store($convert);
        Log::info('StructureService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getStructureById($id )
    {
        $model = $this->StructureInterface->getStructureById($id);
        $datas = array();
        if ($model) {
            $structure = $model->org_structure;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['structure' => $structure, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertStructure($datas)
    {
        $model = $this->StructureInterface->getStructureById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new Structure();
            $model->created_by=auth()->user()->id;

        }
        $model->org_structure = $datas->structure;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyStructureById($id)
    {
        $destory = $this->StructureInterface->destroyStructure($id);
        return new SuccessApiResponse($destory, 200);
    }
}
