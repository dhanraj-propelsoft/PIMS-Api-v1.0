<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\CachetInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Cachet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CachetService
{
    protected $CachetInterface;
    public function __construct(CachetInterface $CachetInterface)
    {
        $this->CachetInterface = $CachetInterface;
    }

    public function index()
    {
        $models = $this->CachetInterface->index();
        $entities = $models->map(function ($model) {
            $cachet = $model->cachet;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['cachet' => $cachet, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'cachet' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertCachet($datas);
        $storeModel = $this->CachetInterface->store($convert);
        Log::info('CachetService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getCachetById($id )
    {
        $model = $this->CachetInterface->getCachetById($id);
        $datas = array();
        if ($model) {
            $cachet = $model->cachet;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['cachet' => $cachet, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertCachet($datas)
    {
        $model = $this->CachetInterface->getCachetById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
        } else {
            $model = new Cachet();
        }
        $model->cachet = $datas->cachet;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : '0';
        return $model;
    }

    public function destroyCachetById($id)
    {
        $destory = $this->CachetInterface->destroyCachet($id);
        return new SuccessApiResponse($destory, 200);
    }
}
