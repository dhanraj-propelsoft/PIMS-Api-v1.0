<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\CommonCountryInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsCommonCountry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommonCountryService
{
    protected $CommonCountryInterface;
    public function __construct(CommonCountryInterface $CommonCountryInterface)
    {
        $this->CommonCountryInterface = $CommonCountryInterface;
    }

    public function index()
    {

        $models = $this->CommonCountryInterface->index();
        $entities = $models->map(function ($model) {
            $country = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['country' => $country, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertCountry($datas);
        $storeModel = $this->CommonCountryInterface->store($convert);
        Log::info('CommonCountryService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCommonCountryById($id = null)
    {
        $model = $this->CommonCountryInterface->getCountryById($id);
        $datas = array();
        if ($model) {
            $name = $model->name;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCountry($datas)
    {
        $model = $this->CommonCountryInterface->getCountryById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsCommonCountry();
        }
        $model->name = $datas->country;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyCountryById($id)
    {
        $destory = $this->CommonCountryInterface->destroyCountry($id);
        return new SuccessApiResponse($destory, 200);
    }
}