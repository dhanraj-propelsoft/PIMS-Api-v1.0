<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\salutationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsPersonSalutation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class SalutationService
{
    protected $SalutationInterface;
    public function __construct(salutationInterface $SalutationInterface)
    {
        $this->SalutationInterface = $SalutationInterface;
    }

    public function index()
    {
        $datas = $this->SalutationInterface->index();

        return new SuccessApiResponse($datas,200);

    }
    public function store($datas)
    {
        $datas = (object) $datas;
        $convert = $this->convertSalutation($datas);
        $storeModel = $this->SalutationInterface->store($convert);
        Log::info('SalutationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel,200);

    }
    public function getSalutationById($id = null)
    {
        $model = $this->SalutationInterface->getSalutationById($id);
        return new SuccessApiResponse($model ,200);
    }
    public function convertSalutation($datas)
    {
        $datasArray = json_decode(json_encode($datas), true);
        $model = $this->SalutationInterface->getSalutationById(isset($datasArray['id']) ? $datasArray['id'] : '');

        if ($model) {
            $model->id = $datasArray['id'];
        } else {
            $model = new PimsPersonSalutation();
        }

        $validator = Validator::make($datasArray, [
            'salutation' => 'required',
        ]);

        if ($validator->fails()) {
            return new ErrorApiResponse($validator->errors(), 500);
        }
        $model->salutation = $datasArray['salutation'];
        $model->active_status = isset($datasArray['active_status'])?$datasArray['active_status']:null;
        return $model;
    }
    public function destroySalutationById($id)
    {
        $destory = $this->SalutationInterface->destroySalutation($id);
        return new SuccessApiResponse($destory ,200);
    }
}
