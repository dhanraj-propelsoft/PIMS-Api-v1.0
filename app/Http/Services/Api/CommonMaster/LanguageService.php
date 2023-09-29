<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\LanguageInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Language;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LanguageService
{
    protected $LanguageInterface;
    public function __construct(LanguageInterface $LanguageInterface)
    {
        $this->LanguageInterface = $LanguageInterface;
    }

    public function index()
    {
        $models = $this->LanguageInterface->index();
        $entities = $models->map(function ($model) {
            $language = $model->language;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $datas = ['language' => $language, 'description'=>$description,'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
        $convert = $this->convertLanguage($datas);
        $storeModel = $this->LanguageInterface->store($convert);
        Log::info('LanguageService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getLanguageById($id )
    {
        $model = $this->LanguageInterface->getLanguageById($id);
        $datas = array();
        if ($model) {
            $language = $model->language;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description=$model->description;
            $id = $model->id;
            $datas = ['language' => $language,'description'=>$description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertLanguage($datas)
    {
        $model = $this->LanguageInterface->getLanguageById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Language();
            $model->created_by=auth()->user()->id;

        }
        $model->language = $datas->language;
        $model->description = isset($datas->description) ? $datas->description :null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyLanguageById($id)
    {
        $destory = $this->LanguageInterface->destroyLanguage($id);
        return new SuccessApiResponse($destory, 200);
    }
}
