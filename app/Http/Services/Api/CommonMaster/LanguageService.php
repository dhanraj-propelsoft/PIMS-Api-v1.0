<?php
namespace App\Http\Services\Api\CommonMaster;

use App\Http\Interfaces\Api\CommonMaster\LanguageInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Language;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LanguageService
{
    protected $LanguageInterface;
    public function __construct(LanguageInterface $LanguageInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->LanguageInterface = $LanguageInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->LanguageInterface->index();
      
        $entities = $models->map(function ($model) {
            $language = $model->language;
            $status = $model->activeStatus->active_type;
            $description=$model->description;
            $languageId = $model->id;
            $datas = ['language' => $language, 'description'=>$description,'status' => $status,  'languageId' => $languageId];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForLanguage($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertLanguage($datas);
        $storeModel = $this->LanguageInterface->store($convert);
        Log::info('LanguageService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForLanguage($datas)
    {
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'language') {
                $rules['language'] = [
                    'required',
                    'string',
                    Rule::unique('pims_com_languages', 'language')->where(function ($query) use ($datas) {
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
    public function getLanguageById($languageId )
    {
        $model = $this->LanguageInterface->getLanguageById($languageId);
        $activeStatus =$this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $language = $model->language;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description=$model->description;
            $languageId = $model->id;
            $datas = ['language' => $language,'description'=>$description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'languageId' => $languageId,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertLanguage($datas)
    {

        if (isset($datas->id)) {
            $model = $this->LanguageInterface->getLanguageById($datas->id);
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

    public function destroyLanguageById($languageId)
    {
        $destory = $this->LanguageInterface->destroyLanguage($languageId);
        return new SuccessApiResponse($destory, 200);
    }
}
