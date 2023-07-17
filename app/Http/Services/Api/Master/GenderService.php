<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\GenderInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonGender;
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
            $name = $model->gender;
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
    public function getGenderById($id = null)
    {
        $model = $this->GenderInterface->getGenderById($id);
        if ($model) {

            $name = $model->gender;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $description = $model->description;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertGender($datas)
    {
        $datasArray = json_decode(json_encode($datas), true);
        $model = $this->GenderInterface->getGenderById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsPersonGender();
        }
        $model->gender = $datas->gender;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : null;
        return $model;
    }

    public function destroyGenderById($id)
    {
        $destory = $this->GenderInterface->destroyGender($id);
        return new SuccessApiResponse($destory, 200);
    }
}
