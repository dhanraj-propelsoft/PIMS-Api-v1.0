<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\GenderInterface;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Http\Responses\ErrorApiResponse;
use App\Models\PimsPersonGender;
use Illuminate\Support\Facades\Log;


class GenderService
{
    protected $GenderInterface;
    public function __construct(GenderInterface $GenderInterface)
    {
        $this->GenderInterface = $GenderInterface;
    }

    public function index()
    {
        $datas = $this->GenderInterface->index();

        return new SuccessApiResponse($datas,200);

    }
    public function store($datas)
    {
        $datas = (object) $datas;
        $convert = $this->convertGender($datas);
        $storeModel = $this->GenderInterface->store($convert);
        Log::info('GenderService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel,200);
    }
    public function getGenderById($id = null)
    {
        $model = $this->GenderInterface->getGenderById($id);
        return new SuccessApiResponse($model,200);

    }
    public function convertGender($datas)
    {
        $datasArray = json_decode(json_encode($datas), true);
        $model = $this->GenderInterface->getGenderById(isset($datasArray['id']) ? $datasArray['id'] : '');

        if ($model) {
            $model->id = $datasArray['id'];
        } else {
            $model = new PimsPersonGender();
        }

        $validator = Validator::make($datasArray, [
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            $error=$validator->errors();
            return new ErrorApiResponse($error, 500);
        }
        $model->gender = $datasArray['gender'];
        $model->active_status = isset($datasArray['active_status'])?$datasArray['active_status']:null;
        return $model;
    }


    public function destroyGenderById($id)
    {
        $destory = $this->GenderInterface->destroyGender($id);
        return new SuccessApiResponse($destory,200);
    }
}
