<?php
namespace App\Http\Services\Api\PersonMaster;

 use App\Http\Interfaces\Api\PersonMaster\QualificationInterface;
 use App\Http\Interfaces\Api\PFM\ActiveStatusInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Qualification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QualificationService
{
    protected $QualificationInterface;
    public function __construct(QualificationInterface $QualificationInterface,ActiveStatusInterface $ActiveStatusInterface)
    {
        $this->QualificationInterface = $QualificationInterface;
        $this->ActiveStatusInterface = $ActiveStatusInterface;

    }

public function index()
    {
        $models = $this->QualificationInterface->index();
        $entities = $models->map(function ($model) {
            $qualification = $model->qualification;
            $status = $model->activeStatus->active_type;
            $description = $model->description;
            $qualificationId = $model->id;
            $datas = ['qualification' => $qualification, 'status' => $status,'qualificationId' => $qualificationId, 'description' => $description];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);

    }
    public function store($datas)
    {
       
        $validation = $this->ValidationForQualification($datas);
        if ($validation->data['errors'] === false) {
        $datas = (object) $datas;
        $convert = $this->convertQualification($datas);
        $storeModel = $this->QualificationInterface->store($convert);
        Log::info('QualificationService >Store Return.' . json_encode($storeModel));
        return new SuccessApiResponse($storeModel, 200);
    } else {
        return $validation->data['errors'];
    }
    }
    public function ValidationForQualification($datas)
    {
      
        $rules = [];

        foreach ($datas as $field => $value) {
            if ($field === 'qualification') {
                $rules['qualification'] = [
                    'required',
                    'string',
                    Rule::unique('pims_person_qualifications', 'qualification')->where(function ($query) use ($datas) {
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
    public function getQualificationById($qualificationId)
    {
        $model = $this->QualificationInterface->getQualificationById($qualificationId);
        $activeStatus =$this->ActiveStatusInterface->index();

        $datas = array();
        if ($model) {
            $qualification = $model->qualification;
            $status = $model->activeStatus->active_type;
            $activeStatusId = $model->pfm_active_status_id;
            $description = $model->description;
            $qualificationId = $model->id;
            $datas = ['qualification' => $qualification, 'status' => $status, 'activeStatusId' => $activeStatusId, 'qualificationId' => $qualificationId, 'description' => $description,'activeStatus'=>$activeStatus];
        }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertQualification($datas)
    {

        if (isset($datas->id)) {
            $model = $this->QualificationInterface->getQualificationById($datas->id);
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

    public function destroyQualificationById($qualificationId)
    {
        $destory = $this->QualificationInterface->destroyQualification($qualificationId);
        return new SuccessApiResponse($destory, 200);
    }
}
