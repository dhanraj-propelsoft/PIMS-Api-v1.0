<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\CommonStateInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsCommonState;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommonStateService
{
    protected $CommonStateInterface;
    public function __construct(CommonStateInterface $CommonStateInterface)
    {
        $this->CommonStateInterface = $CommonStateInterface;
    }

    public function index()
    {

        $models = $this->CommonStateInterface->index();
        $entities = $models->map(function ($model) {
            $state = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $country_id = $model->country_id;
            $id = $model->id;
            $datas = ['state' => $state, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'country_id' => $country_id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'state' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();

            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertState($datas);
        $storeModel = $this->CommonStateInterface->store($convert);
        Log::info('CommonStateService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getStateById($id = null)
    {
        $model = $this->CommonStateInterface->getStateById($id);
        $datas = array();
        if ($model) {
            $state = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $country_id = $model->country_id;
            $id = $model->id;
            $datas = ['state' => $state, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'country_id' => $country_id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertState($datas)
    {
        $model = $this->CommonStateInterface->getStateById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsCommonState();
        }
        $model->name = $datas->state;
        $model->country_id = isset($datas->countryId) ? $datas->countryId : null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyStateById($id)
    {
        $destory = $this->CommonStateInterface->destroyState($id);
        return new SuccessApiResponse($destory, 200);
    }
}