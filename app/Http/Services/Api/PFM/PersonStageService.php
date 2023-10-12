<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\PersonStageInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\PersonStage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PersonStageService
{
    protected $PersonStageInterface;
    public function __construct(PersonStageInterface $PersonStageInterface)
    {
        $this->PersonStageInterface = $PersonStageInterface;
    }

    public function index()
    {
        $models = $this->PersonStageInterface->index();
        $entities = $models->map(function ($model) {
            $personStage = $model->person_stage;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $datas = ['personStage' => $personStage, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForPersonStage($datas);
        if (!$validation) {
            $datas = (object) $datas;
            $convert = $this->convertPersonStage($datas);
            $storeModel = $this->PersonStageInterface->store($convert);
            Log::info('PersonStageService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        }
        else{
            return $validation;
        }
    }
    public function ValidationForPersonStage($datas){
        $rules =[];

        foreach ($datas as $field => $value){
            if($field === 'personStage'){
                $rules['personStage'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_person_stage', 'person_stage')->where(function ($query) use ($datas){
                        $query->whereNull('deleted_flag');
                        if(isset($datas['id'])){
                            $query->where('id', '!=', $datas['id']);
                        }
                    }),
                ];
            }
            $validator = Validator::make($datas, $rules);
            if($validator->fails()){
                return response()->json(['errors' => $validator->errors()], 400);
            }
        }
    }
    public function getPersonStageById($id )
    {
        $model = $this->PersonStageInterface->getPersonStageById($id);
        $datas = array();
        if ($model) {
            $personStage = $model->person_stage;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['personStage' => $personStage, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertPersonStage($datas)
    {
        $model = $this->PersonStageInterface->getPersonStageById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new PersonStage();
            $model->created_by=auth()->user()->id;

        }
        $model->person_stage = $datas->personStage;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroyPersonStageById($id)
    {
        $destory = $this->PersonStageInterface->destroyPersonStage($id);
        return new SuccessApiResponse($destory, 200);
    }
}
