<?php
namespace App\Http\Services\Api\PersonMaster;

 use App\Http\Interfaces\Api\PersonMaster\QualificationInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Qualification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QualificationService
{
    protected $QualificationInterface;
    public function __construct(QualificationInterface $QualificationInterface)
    {
        $this->QualificationInterface = $QualificationInterface;
    }

public function index()
    {
     

        $models = $this->QualificationInterface->index();
        $entities = $models->map(function ($model) {
            $qualification = $model->qualification;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['qualification' => $qualification, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
        $validator = Validator::make($datas, [
            'qualification' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            //dd($error);
            return new ErrorApiResponse($error, 300);
        }
        $datas = (object) $datas;
        $convert = $this->convertQualification($datas);
        $storeModel = $this->QualificationInterface->store($convert);
        Log::info('GenderService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    }
    public function getQualificationById($id)
    {
        $model = $this->QualificationInterface->getQualificationById($id);
        $datas = array();
        if ($model) {
            $qualification = $model->qualification;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['qualification' => $qualification, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id, 'description' => $description];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertQualification($datas)
    {
        $model = $this->QualificationInterface->getQualificationById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;
        } else {
            $model = new Qualification();
            $model->created_by=auth()->user()->id;
        }
        $model->qualification = $datas->qualification;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyQualificationById($id)
    {
        $destory = $this->QualificationInterface->destroyQualification($id);
        return new SuccessApiResponse($destory, 200);
    }
}
