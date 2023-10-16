<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\RelationShipInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\RelationShip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RelationShipService
{
    protected $RelationShipInterface;
    public function __construct(RelationShipInterface $RelationShipInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->RelationShipInterface = $RelationShipInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

    public function index()
    {
        $models = $this->RelationShipInterface->index();
        $entities = $models->map(function ($model) {
            $relationship = $model->person_relationship;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $relationshipId = $model->id;
            $datas = ['relationship' => $relationship, 'status' => $status, 'relationshipId' => $relationshipId, 'description' => $description];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForRelationship($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertPersonRelationShip($datas);
        $storeModel = $this->RelationShipInterface->store($convert);
        Log::info('RelationShipService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForRelationship($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'relationship') {
                $rules['relationship'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_relationships', 'person_relationship')->where(function ($query) use ($datas) {
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
    public function convertPersonRelationShip($datas)
    {
        if (isset($datas->id)) {
            $model = $this->RelationShipInterface->getRelationShipById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new RelationShip();
            $model->created_by = auth()->user()->id;
        }
        $model->person_relationship = $datas->relationship;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function getRelationShipById($relationshipId)
    {
        $model = $this->RelationShipInterface->getRelationShipById($relationshipId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $relationship = $model->person_relationship;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $relationshipId = $model->id;
            $datas = ['relationship' => $relationship, 'status' => $status, 'activeStatusId' => $activeStatusId, 'relationshipId' => $relationshipId, 'description' => $description,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyRelationShipById($relationshipId)
    {
        $destory = $this->RelationShipInterface->destroyRelationShip($relationshipId);
        return new SuccessApiResponse($destory, 200);
    }

}
