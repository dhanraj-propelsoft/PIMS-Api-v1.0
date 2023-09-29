<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\OriginInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Origin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OriginService
{
    protected $OriginInterface;
    public function __construct(OriginInterface $OriginInterface)
    {
        $this->OriginInterface = $OriginInterface;
    }

    public function index()
    {
        $models = $this->OriginInterface->index();
        $entities = $models->map(function ($model) {
            $origin = $model->origin;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['origin' => $origin, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'origin' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertOrigin($datas);
        $storeModel = $this->OriginInterface->store($convert);
        Log::info('OriginService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getOriginById($id )
    {
        $model = $this->OriginInterface->getOriginById($id);
        $datas = array();
        if ($model) {
            $origin = $model->origin;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['origin' => $origin, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertOrigin($datas)
    {
        $model = $this->OriginInterface->getOriginById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new Origin();
        }
        $model->origin = $datas->origin;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : '0';
        return $model;
    }

    public function destroyOriginById($id)
    {
        $destory = $this->OriginInterface->destroyOrigin($id);
        return new SuccessApiResponse($destory, 200);
    }
}
