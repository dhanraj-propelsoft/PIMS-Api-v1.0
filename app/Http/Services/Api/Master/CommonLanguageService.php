<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\CommonLanguageInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsCommonLanguage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommonLanguageService
{
    protected $CommonLanguageInterface;
    public function __construct(CommonLanguageInterface $CommonLanguageInterface)
    {
        $this->CommonLanguageInterface = $CommonLanguageInterface;
    }

    public function index()
    {
        $models = $this->CommonLanguageInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->name;
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
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertCommonLanguage($datas);
        $storeModel = $this->CommonLanguageInterface->store($convert);
        Log::info('CommonLanguageService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCommonLanguageById($id = null)
    {
        $model = $this->CommonLanguageInterface->getCommonLanguageById($id);
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
    public function convertCommonLanguage($datas)
    {
        $model = $this->CommonLanguageInterface->getCommonLanguageById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsCommonLanguage();
        }
        $model->name = $datas->language;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyCommonLanguageById($id)
    {
        $destory = $this->CommonLanguageInterface->destroyCommonLanguage($id);
        return new SuccessApiResponse($destory, 200);
    }
}
