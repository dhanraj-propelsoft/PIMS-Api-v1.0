<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\BankAccountTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PimsBankAccountType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BankAccountTypeService
{
    protected $BankAccountTypeInterface;
    public function __construct(BankAccountTypeInterface $BankAccountTypeInterface)
    {
        $this->BankAccountTypeInterface = $BankAccountTypeInterface;
    }

    public function index()
    {
        $models = $this->BankAccountTypeInterface->index();
        $entities = $models->map(function ($model) {
            $name = $model->account_type;
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
            'bankAccountType' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertBankAccountType($datas);
        $storeModel = $this->BankAccountTypeInterface->store($convert);
        Log::info('BankAccountTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getBankAccountTypeById($id = null)
    {
        $model = $this->BankAccountTypeInterface->getBankAccountTypeById($id);
        $datas = array();
        if ($model) {
            $name = $model->account_type;
            $status = ($model->active_status == 1) ? "Active" : "In-Active";
            $activeStatus = $model->active_status;
            $id = $model->id;
            $datas = ['name' => $name, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBankAccountType($datas)
    {
        $model = $this->BankAccountTypeInterface->getBankAccountTypeById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsBankAccountType();
        }
        $model->account_type = $datas->bankAccountType;
        $model->active_status = isset($datas->active_status) ? $datas->active_status : '0';
        return $model;
    }

    public function destroyBankAccountTypeById($id)
    {
        $destory = $this->BankAccountTypeInterface->destroyBankAccountType($id);
        return new SuccessApiResponse($destory, 200);
    }
}
