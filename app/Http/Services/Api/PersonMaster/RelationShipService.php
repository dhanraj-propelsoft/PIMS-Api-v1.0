<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\RelationShipInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\RelationShip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RelationShipService
{
    protected $RelationShipInterface;
    public function __construct(RelationShipInterface $RelationShipInterface)
    {
        $this->RelationShipInterface = $RelationShipInterface;
    }

    public function index()
    {
        $models = $this->RelationShipInterface->index();
        $entities = $models->map(function ($model) {
            $relationship = $model->person_relationship;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['relationship' => $relationship, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'relationShip' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertPersonRelationShip($datas);
        $storeModel = $this->RelationShipInterface->store($convert);
        Log::info('BloodGroupService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function convertPersonRelationShip($datas)
    {
        $model = $this->RelationShipInterface->getRelationShipById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new RelationShip();
            $model->created_by=auth()->user()->id;
        }
        $model->person_relationship = $datas->relationShip;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function getRelationShipById($id)
    {
        $model = $this->RelationShipInterface->getRelationShipById($id);
        $datas = array();
        if ($model) {
            $relationship = $model->person_relationship;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['relationship' => $relationship, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyRelationShipById($id)
    {
        $destory = $this->RelationShipInterface->destroyRelationShip($id);
        return new SuccessApiResponse($destory, 200);
    }

}
