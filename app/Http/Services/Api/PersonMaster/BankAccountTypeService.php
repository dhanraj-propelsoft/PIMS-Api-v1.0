<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BankAccountTypeInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\BankAccountType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BankAccountTypeService
{
    protected $BankAccountTypeInterface;
    public function __construct(BankAccountTypeInterface $BankAccountTypeInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->BankAccountTypeInterface = $BankAccountTypeInterface;
        $this->ActiveStatusInterface=$ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->BankAccountTypeInterface->index();
       
        $entities = $models->map(function ($model) {
            $bankAccountType = $model->bank_account_type;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $bankAccountId = $model->id;
            $datas = ['bankAccountType' => $bankAccountType, 'description' => $description, 'status' => $status,  'bankAccountId' => $bankAccountId];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }

    public function store($datas)
    {
    $validation = $this->ValidationForBankAccountType($datas);
    if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertBankAccountType($datas);
        $storeModel = $this->BankAccountTypeInterface->store($convert);
        Log::info('BankAccountTypeService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForBankAccountType($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'bankAccountType') {
                $rules['bankAccountType'] = [
                    'required',
                    'string',
                    Rule::unique('pims_bank_account_types', 'bank_account_type')->where(function ($query) use ($datas) {
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
    public function getBankAccountTypeById($bankAccountId)
    {
        $model = $this->BankAccountTypeInterface->getBankAccountTypeById($bankAccountId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $bankAccountType = $model->bank_account_type;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $bankAccountId = $model->id;
            $datas = ['bankAccountType' => $bankAccountType, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'bankAccountId' => $bankAccountId,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBankAccountType($datas)
    {
        if (isset($datas->id)) {
            $model = $this->BankAccountTypeInterface->getBankAccountTypeById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new BankAccountType();
            $model->created_by = auth()->user()->id;
        }
        $model->bank_account_type = $datas->bankAccountType;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBankAccountTypeById($bankAccountId)
    {
        $destory = $this->BankAccountTypeInterface->destroyBankAccountType($bankAccountId);
        return new SuccessApiResponse($destory, 200);
    }
}
