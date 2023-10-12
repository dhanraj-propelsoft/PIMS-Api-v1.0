<?php
namespace App\Http\Services\Api\PFM;

use App\Http\Interfaces\Api\PFM\SurvivalInterface;
use App\Http\Responses\ErrorApiResponse;
use App\Http\Responses\SuccessApiResponse;
use App\Models\Survival;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SurvivalService
{
    protected $SurvivalInterface;
    public function __construct(SurvivalInterface $SurvivalInterface)
    {
        $this->SurvivalInterface = $SurvivalInterface;
    }

    public function index()
    {
        $models = $this->SurvivalInterface->index();
        $entities = $models->map(function ($model) {
            $survival = $model->survival;
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $status = isset($model->activeStatus->active_type) ? $model->activeStatus->active_type : null;
            $datas = ['survival' => $survival, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
            return $datas;
        });

        return new SuccessApiResponse($entities, 200);
    }
    public function store($datas)
    {
        $validation = $this->ValidationForSurvival($datas);
        if (!$validation) {
            $datas = (object) $datas;
            $convert = $this->convertSurvival($datas);
            $storeModel = $this->SurvivalInterface->store($convert);
            Log::info('SurvivalService >Store Return.' . json_encode($storeModel));
            return new SuccessApiResponse($storeModel, 200);
        }
        else{
            return $validation;
        }
    }
    public function ValidationForSurvival($datas){
        $rules =[];

        foreach ($datas as $field => $value){
            if($field === 'survival'){
                $rules['survival'] = [
                    'required',
                    'string',
                    Rule::unique('pfm_survival', 'survival')->where(function ($query) use ($datas){
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
    public function getSurvivalById($id )
    {
        $model = $this->SurvivalInterface->getSurvivalById($id);
        $datas = array();
        if ($model) {
            $survival = $model->survival;
            $status = ($model->pfm_active_status_id == 1) ? "Active" : "In-Active";
            $activeStatus = $model->pfm_active_status_id;
            $description = $model->description;
            $id = $model->id;
            $datas = ['survival' => $survival, 'description' => $description, 'status' => $status, 'activeStatus' => $activeStatus, 'id' => $id];
                }
        return new SuccessApiResponse($datas, 200);

    }
    public function convertSurvival($datas)
    {
        $model = $this->SurvivalInterface->getSurvivalById(isset($datas->id) ? $datas->id : '');

        if ($model) {
            $model->id = $datas->id;
            $model->last_updated_by=auth()->user()->id;

        } else {
            $model = new Survival();
            $model->created_by=auth()->user()->id;
        }
        $model->survival = $datas->survival;
        $model->description = isset($datas->description) ? $datas->description : null;
        $model->pfm_active_status_id = isset($datas->activeStatus) ? $datas->activeStatus : null;
        return $model;
    }

    public function destroySurvivalById($id)
    {
        $destory = $this->SurvivalInterface->destroySurvival($id);
        return new SuccessApiResponse($destory, 200);
    }
}
