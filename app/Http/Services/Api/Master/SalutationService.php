<?php
namespace App\Http\Services\Api\Master;

use App\Http\Interfaces\Api\Master\salutationInterface;
use App\Models\PimsPersonSalutation;
use Illuminate\Support\Facades\Log;


class SalutationService
{
    public function __construct(salutationInterface $SalutationInterface)
    {
        $this->SalutationInterface = $SalutationInterface;
    }

    public function index()
    {
        $datas = $this->SalutationInterface->index();

        return $datas;

    }
    public function store($datas)
    {
        $datas = (object) $datas;
        $convert = $this->convertSalutation($datas);
        $storeModel = $this->SalutationInterface->store($convert);
        Log::info('SalutationService >Store Return.' . json_encode($storeModel));
        return $storeModel;

    }
    public function getSalutationById($id = null)
    {
        $model = $this->SalutationInterface->getSalutationById($id);
        return $model;

    }
    public function convertSalutation($datas)
    {
        $model = $this->getSalutationById(isset($datas->id) ? $datas->id : '');
        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new PimsPersonSalutation();
        }
        $model->salutation = $datas->salutation;
        $model->active_status = $datas->active_status;
        return $model;
    }
    public function destroySalutationById($id)
    {
        $destory = $this->SalutationInterface->destroySalutation($id);
        return $destory;
    }
}
