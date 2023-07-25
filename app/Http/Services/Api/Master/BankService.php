<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\BankInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsBank;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BankService
{
    protected $BankInterface;
    public function __construct(BankInterface $BankInterface)
    {
        $this->BankInterface = $BankInterface;
    }

    public function index()
    {
        $models = $this->BankInterface->index();
        $entities = $models->map(function ($model) {
            $bankName = $model->bank;
            $ifsc = $model->ifsc;
            $micr = $model->micr;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['bankName' => $bankName, 'ifsc' => $ifsc, 'micr' => $micr, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }

    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'bankName' => 'required',
            'ifsc' => 'required',
            'micr' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();

            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertBank($datas);
        $storeModel = $this->BankInterface->store($convert);
        Log::info('BankService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getBankById($id = null)
    {
        $model = $this->BankInterface->getBankById($id);
        $datas = array();
        if ($model) {
            $bankName = $model->bank;
            $ifsc = $model->ifsc;
            $micr = $model->micr;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['bankName' => $bankName, 'ifsc' => $ifsc, 'micr' => $micr, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBank($datas)
    {
        $model = $this->BankInterface->getBankById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsBank();
        }
        $model->bank = $datas->bankName;
        $model->ifsc = $datas->ifsc;
        $model->micr = $datas->micr;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyBankById($id)
    {
        $destory = $this->BankInterface->destroyBank($id);
        return new SuccessApiResponse($destory, 200);
    }
}
