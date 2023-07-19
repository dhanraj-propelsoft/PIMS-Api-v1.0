<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\RelationShipInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonRelationShip;
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
            $name = $model->person_relationship;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
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
        } else {
            $model = new PimsPersonRelationShip();
        }
        $model->person_relationship = $datas->relationShip;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function getRelationShipById($id = null)
    {
        $model = $this->RelationShipInterface->getRelationShipById($id);
        $datas = array();
        if ($model) {
            $name = $model->person_relationship;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function destroyRelationShipById($id)
    {
        $destory = $this->RelationShipInterface->destroyRelationShip($id);
        return new SuccessApiResponse($destory, 200);
    }

}
