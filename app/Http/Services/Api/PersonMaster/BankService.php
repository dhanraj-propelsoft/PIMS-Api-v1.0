<?php
namespace App\Http\Services\Api\PersonMaster;

use App\Http\Interfaces\Api\PersonMaster\BankInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Bank;
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
            $orgId = $model->org_id;
            $description = $model->description;
            $bankAlias = $model->bank_alias;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $id = $model->id;
            $datas = ['bankName' => $bankName, 'orgId' => $orgId, 'bankAlias' => $bankAlias, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });
        return new SuccessApiResponse($entities, 200);
    }

    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'bank' => 'required',
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
    public function getBankById($id)
    {
        $model = $this->BankInterface->getBankById($id);
        $datas = array();
        if ($model) {
            $bankName = $model->bank;
            $orgId = $model->org_id;
            $description = $model->description;
            $bankAlias = $model->bank_alias;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $id = $model->id;
            $datas = ['bankName' => $bankName, 'orgId' => $orgId, 'bankAlias' => $bankAlias, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertBank($datas)
    {
        $model = $this->BankInterface->getBankById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
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

    public function destroyBankById($id)
    {
        $destory = $this->BankInterface->destroyBank($id);
        return new SuccessApiResponse($destory, 200);
    }
}
