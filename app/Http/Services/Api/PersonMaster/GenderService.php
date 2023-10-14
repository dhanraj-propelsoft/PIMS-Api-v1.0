<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\GenderInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Gender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GenderService
{
    protected $GenderInterface;
    public function __construct(GenderInterface $GenderInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->GenderInterface = $GenderInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {

        $models = $this->GenderInterface->index();
        $entities = $models->map(function ($model) {
            $gender = $model->gender;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $genderId = $model->id;
            $datas = ['gender' => $gender, 'status' => $status,  'genderId' => $genderId, 'description' => $description];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validation = $this->ValidationForGender($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertGender($datas);
        $storeModel = $this->GenderInterface->store($convert);
        Log::info('GenderService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForGender($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'gender') {
                $rules['gender'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_genders', 'gender')->where(function ($query) use ($datas) {
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
    public function getGenderById($genderId)
    {
        $model = $this->GenderInterface->getGenderById($genderId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $gender = $model->gender;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $genderId = $model->id;
            $datas = ['gender' => $gender, 'status' => $status, 'activeStatusId' => $activeStatusId, 'genderId' => $genderId, 'description' => $description,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertGender($datas)
    {

        if (isset($datas->id)) {
            $model = $this->GenderInterface->getGenderById($datas->id);
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Gender();
            $model->created_by=auth()->user()->id;
        }
        $model->gender = $datas->gender;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyGenderById($genderId)
    {
        $destory = $this->GenderInterface->destroyGender($genderId);
        return new SuccessApiResponse($destory, 200);
    }
}
