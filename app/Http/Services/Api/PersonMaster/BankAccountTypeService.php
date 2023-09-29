<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BankAccountTypeInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\BankAccountType;
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
            $bankAccountType = $model->bank_account_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['bankAccountType' => $bankAccountType, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
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
    public function getBankAccountTypeById($id)
    {
        $model = $this->BankAccountTypeInterface->getBankAccountTypeById($id);
        $datas = array();
        if ($model) {
            $bankAccountType = $model->bank_account_type;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['bankAccountType' => $bankAccountType, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBankAccountType($datas)
    {
        $model = $this->BankAccountTypeInterface->getBankAccountTypeById(isset($datas->id) ? $datas->id : '');
        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new BankAccountType();
            $model->created_by=auth()->user()->id;
        }
        $model->bank_account_type = $datas->bankAccountType;
        $model->description = isset($datas->description) ? $datas->description : null;   
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBankAccountTypeById($id)
    {
        $destory = $this->BankAccountTypeInterface->destroyBankAccountType($id);
        return new SuccessApiResponse($destory, 200);
    }
}
