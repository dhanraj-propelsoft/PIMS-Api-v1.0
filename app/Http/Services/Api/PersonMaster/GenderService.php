<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\GenderInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Gender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GenderService
{
    protected $GenderInterface;
    public function __construct(GenderInterface $GenderInterface)
    {
        $this->GenderInterface = $GenderInterface;
    }

    public function index()
    {

        $models = $this->GenderInterface->index();
        $entities = $models->map(function ($model) {
            $gender = $model->gender;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['gender' => $gender, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            //dd($error);
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertGender($datas);
        $storeModel = $this->GenderInterface->store($convert);
        Log::info('GenderService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getGenderById($id)
    {
        $model = $this->GenderInterface->getGenderById($id);
        $datas = array();
        if ($model) {
            $gender = $model->gender;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['gender' => $gender, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertGender($datas)
    {
        $model = $this->GenderInterface->getGenderById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
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

    public function destroyGenderById($id)
    {
        $destory = $this->GenderInterface->destroyGender($id);
        return new SuccessApiResponse($destory, 200);
    }
}
