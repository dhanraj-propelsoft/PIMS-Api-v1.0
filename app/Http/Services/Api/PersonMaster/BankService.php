<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BankInterface;
use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Bank;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BankService
{
    protected $BankInterface;
    public function __construct(BankInterface $BankInterface, ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->BankInterface = $BankInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;
    }

    public function index()
    {
        $models = $this->BankInterface->index();
        $entities = $models->map(function ($model) {
            $bankName = $model->bank;
            $orgId = $model->org_id;
            $description = $model->description;
            $bankAlias = $model->bank_alias;
            $status = $model->activeStatus->active_type;
            $activeStatus = $model->pfm_active_status_id;
            $bankId = $model->id;
            $datas = ['bankName' => $bankName, 'orgId' => $orgId, 'bankAlias' => $bankAlias, 'description' => $description, 'status' => $status, 'bankId' => $bankId];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }

    public function store($datas)
    {
        $validation = $this->ValidationForBank($datas);
        if ($validation->data['errors'] === false) {
            $datas = (object) $datas;
            $convert = $this->convertBank($datas);
            $storeModel = $this->BankInterface->store($convert);
            Log::info('BankService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        } else {
            return $validation->data['errors'];
        }
    }
    public function ValidationForBank($datas)
    {

        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'bank') {
                $rules['bank'] = [
                    'required',
                    'string',
                    Rule::unique('pims_banks', 'bank')->where(function ($query) use ($datas) {
                        $query->whereNull('deleted_flag');
                        if (isset($datas['id'])) {
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),

                ];
            } elseif ($field === 'orgId') {
                $rules['orgId'] = ['required', 'integer'];
            } elseif ($field === 'bankAlias') {
                $rules['bankAlias'] = ['required', 'string'];
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
    public function getBankById($BankId)
    {
        $model = $this->BankInterface->getBankById($BankId);
        $activeStatus = $this->ActiveStatusInterface->index();
        $datas = array();
        if ($model) {
            $bankName = $model->bank;
            $orgId = $model->org_id;
            $description = $model->description;
            $bankAlias = $model->bank_alias;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $bankId = $model->id;
            $datas = ['bankName' => $bankName, 'orgId' => $orgId, 'bankAlias' => $bankAlias, 'description' => $description, 'status' => $status, 'activeStatusId' => $activeStatusId, 'bankId' => $bankId, 'activeStatus' => $activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBank($datas)
    {

        if (isset($datas->id)) {
            $model = $this->BankInterface->getBankById($datas->id);
            $model->last_updated_by = auth()->user()->id;
        } else {
            $model = new Bank();
            $model->created_by = auth()->user()->id;
        }
        $model->bank = $datas->bank;
        $model->org_id = isset($datas->orgId) ? $datas->orgId : null;
        $model->bank_alias = isset($datas->bankAlias) ? $datas->bankAlias : null;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyBankById($BankId)
    {
        $destory = $this->BankInterface->destroyBank($BankId);
        return new SuccessApiResponse($destory, 200);
    }
}
