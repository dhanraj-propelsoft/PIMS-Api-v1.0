<?php
namespace App\Http\Services\Api\OrganizationMaster;

use App\Http\Interfaces\Api\OrganizationMaster\StructureInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Organization\Structure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StructureService
{
    protected $StructureInterface, $ActiveStatusInterface;
    public function __construct(StructureInterface $StructureInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->StructureInterface = $StructureInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->StructureInterface->index();
        $entities = $models->map(function ($model) {
            $structure = $model->org_structure;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $structureId = $model->id;
            $datas = ['structure' => $structure,'description' => $description, 'status' => $status, 'structureId' => $structureId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForStructure($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertStructure($datas);
        $storeModel = $this->StructureInterface->store($convert);
        Log::info('StructureService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForStructure($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'structure') {
                $rules['structure'] = [
                    'required',
                    'string',
                    Rule::unique('pims_org_structures', 'org_structure')->where(function ($query) use ($datas) {
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

    public function getStructureById($structureId)
    {
        $model = $this->StructureInterface->getStructureById($structureId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $structure = $model->org_structure;
            $status = $model->activeStatus->active_type;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $structureId = $model->id;
            $datas = ['structure' => $structure, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'structureId' => $structureId, 'activeStatus' => $activeStatus];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertStructure($datas)
    {

        if (isset($datas->id)) {
            $model = $this->StructureInterface->getStructureById($datas->id);
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

    public function destroyStructureById($structureId)
    {
        $destroy = $this->StructureInterface->destroyStructure($structureId);
        if ($destroy) {
            return response()->json(['Success' => true, 'Message' => 'Record Deleted Successfully']);
        } else {
            return response()->json(['Success' => false, 'Message' => 'Record Not Deleted']);
        }
    }
}
