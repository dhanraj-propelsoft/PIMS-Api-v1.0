<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\CountryInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CountryService
{
    protected $CountryInterface;
    public function __construct(CountryInterface $CountryInterface)
    {
        $this->CountryInterface = $CountryInterface;
    }

    public function index()
    {

        $models = $this->CountryInterface->index();
        $entities = $models->map(function ($model) {
            $country = $model->country;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $datas = ['country' => $country, 'description'=>$description,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
        $storeModel = $this->CountryInterface->store($convert);
        Log::info('CountryService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCountryById($id )
    {
        $model = $this->CountryInterface->getCountryById($id);
        $datas = array();
        if ($model) {
            $country = $model->country;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $datas = ['country' => $country,'description'=>$description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCountry($datas)
    {
      
        $model = $this->CountryInterface->getCountryById(isset($datas->id) ? $datas->id : '');

        if ($model){
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Country();
            $model->created_by=auth()->user()->id;
        }
        $model->country = $datas->country;
        $model->numeric_code = isset($datas->numericCode) ? $datas->numericCode :null;
        $model->phone_code = isset($datas->phoneCode) ? $datas->phoneCode :null;
        $model->capital = isset($datas->capital) ? $datas->capital :null;
        $model->flag = isset($datas->flag) ? $datas->flag :null;
        $model->description = isset($datas->description) ? $datas->description :null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus :null;
      
        return $model;
    }

    public function destroyCountryById($id)
    {
        $destory = $this->CountryInterface->destroyCountry($id);
        return new SuccessApiResponse($destory, 200);
    }
}